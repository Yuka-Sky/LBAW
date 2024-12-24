DROP SCHEMA IF EXISTS lbaw2463 CASCADE;
CREATE SCHEMA lbaw2463;
SET SEARCH_PATH TO lbaw2463;

-----------------------------------------
-- Types
-----------------------------------------

CREATE TYPE types AS ENUM ('Vote_on_Post','Comment_on_Post','Followed_user_posted');

-----------------------------------------
-- Tables
-----------------------------------------

-- Note that a plural 'users' name was adopted because user is a reserved word in PostgreSQL.
--R01
CREATE TABLE users (
		
        id SERIAL PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(50) NOT NULL,
        reputation INT NOT NULL,
        is_admin BOOLEAN NOT NULL DEFAULT FALSE
);

--R02
CREATE TABLE post (
    id SERIAL PRIMARY KEY,
    id_user int,
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE SET NULL,
    title VARCHAR(100) NOT NULL,
    subtitle VARCHAR(100),
    content VARCHAR(2000) NOT NULL,
    date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

--R03
CREATE TABLE comment (
    id SERIAL PRIMARY KEY,
    id_user int,
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE SET NULL,
    id_post int,
    FOREIGN KEY (id_post) REFERENCES post(id) ON DELETE CASCADE,
    content VARCHAR(1000) NOT NULL,
    date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

--R04
CREATE TABLE post_vote (
	PRIMARY KEY (id_user, id_post),
    id_user int,
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE SET NULL,
    id_post int,
    FOREIGN KEY (id_post) REFERENCES post(id) ON DELETE CASCADE,
    upvote_bool BOOLEAN DEFAULT TRUE
);

--R05
CREATE TABLE comment_vote (
	PRIMARY KEY (id_user, id_comment),
    id_user int,
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE SET NULL,
    id_comment int,
    FOREIGN KEY (id_comment) REFERENCES comment(id) ON DELETE CASCADE,
    upvote_bool BOOLEAN NOT NULL DEFAULT TRUE
);

--R06
CREATE TABLE follows (
	PRIMARY KEY (id_user_follower, id_user_followed),
    id_user_follower int,
    FOREIGN KEY (id_user_follower) REFERENCES users(id) ON DELETE CASCADE,
    id_user_followed int,
    FOREIGN KEY (id_user_followed) REFERENCES users(id) ON DELETE CASCADE
);

--R07
CREATE TABLE blocks (
	PRIMARY KEY (id_user_blocker, id_user_blocked),
    id_user_blocker int,
    FOREIGN KEY (id_user_blocker) REFERENCES users(id) ON DELETE CASCADE,
    id_user_blocked int,
    FOREIGN KEY (id_user_blocked) REFERENCES users(id) ON DELETE CASCADE
);

--R08
CREATE TABLE tag (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

--R09
CREATE TABLE post_tag (
	PRIMARY KEY (id_post, id_tag),
    id_post int,
    FOREIGN KEY (id_post) REFERENCES post(id) ON DELETE CASCADE,
    id_tag int,
    FOREIGN KEY (id_tag) REFERENCES tag(id) ON DELETE CASCADE
);

--R10
CREATE TABLE post_notification (
    id SERIAL PRIMARY KEY,
    id_post int,
    FOREIGN KEY (id_post) REFERENCES post(id) ON DELETE SET NULL,
    type types NOT NULL,
    id_user_notified int,
    FOREIGN KEY (id_user_notified) REFERENCES users(id) ON DELETE CASCADE,
    date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    id_user_generator int,
    FOREIGN KEY (id_user_generator) REFERENCES users(id) ON DELETE SET NULL
);

--R11
CREATE TABLE comment_notification (
    id SERIAL PRIMARY KEY,
    id_comment int,
    FOREIGN KEY (id_comment) REFERENCES comment(id) ON DELETE SET NULL,
    id_user_notified int,
    FOREIGN KEY (id_user_notified) REFERENCES users(id) ON DELETE CASCADE,
    date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    id_user_generator int,
    FOREIGN KEY (id_user_generator) REFERENCES users(id) ON DELETE SET NULL
);

--R12
CREATE TABLE ban (
    id SERIAL PRIMARY KEY,
    id_user int,
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE,
    id_admin int,
    FOREIGN KEY (id_admin) REFERENCES users(id)  ON DELETE SET NULL,
    reason VARCHAR(200) NOT NULL,
    permanent_bool BOOLEAN NOT NULL,
    begin_date TIMESTAMP NOT NULL,
    end_date TIMESTAMP NOT NULL CHECK (begin_date <= end_date)
);



CREATE INDEX idx_post_data ON post USING btree (date);

CREATE INDEX idx_notification_user ON post_notification USING hash (id_user_notified);

CREATE INDEX idx_comment_post ON comment USING hash (id_post);


ALTER TABLE post
ADD COLUMN tsvectors TSVECTOR;

CREATE FUNCTION post_search_update() RETURNS TRIGGER AS $$
BEGIN
    NEW.tsvectors := (
        setweight(to_tsvector('portuguese', NEW.title), 'A') ||
        setweight(to_tsvector('portuguese', NEW.content), 'B')
    );
    RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER post_search_update
BEFORE INSERT OR UPDATE ON post
FOR EACH ROW
EXECUTE PROCEDURE post_search_update();

CREATE INDEX search_idx ON post USING GIST (tsvectors);


ALTER TABLE users
ADD COLUMN tsvectors TSVECTOR;

CREATE FUNCTION user_search_update() RETURNS TRIGGER AS $$
BEGIN
    NEW.tsvectors := to_tsvector('portuguese', NEW.name);
    RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER user_search_update
BEFORE INSERT OR UPDATE ON users
FOR EACH ROW
EXECUTE PROCEDURE user_search_update();

CREATE INDEX search_user_idx ON users USING GIN (tsvectors);


CREATE FUNCTION check_comment_date() RETURNS TRIGGER AS $$
DECLARE
    post_date TIMESTAMP;
BEGIN
    SELECT date INTO post_date FROM post WHERE id = NEW.id_post;
    IF NEW.date < post_date THEN
        RAISE EXCEPTION 'A comment cannot be dated before its respective post';
    END IF;

    RETURN NEW;
END $$ LANGUAGE plpgsql;

CREATE TRIGGER validate_comment_date
BEFORE INSERT OR UPDATE ON comment
FOR EACH ROW
EXECUTE FUNCTION check_comment_date();


CREATE OR REPLACE FUNCTION insert_post_notification_vote()
RETURNS TRIGGER AS $$
DECLARE
    post_author INT;
BEGIN
    SELECT id_user INTO post_author FROM post WHERE id = NEW.id_post;

    IF NEW.upvote_bool = TRUE THEN
        IF NOT EXISTS (
            SELECT 1
            FROM post_notification
            WHERE id_post = NEW.id_post
              AND id_user_generator = NEW.id_user
              AND type = 'Vote_on_Post'
        ) THEN
            INSERT INTO post_notification (id_post, type, id_user_notified, date, id_user_generator)
            VALUES (NEW.id_post, 'Vote_on_Post', post_author, CURRENT_TIMESTAMP, NEW.id_user);
        END IF;
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER post_vote_notification_trigger
AFTER INSERT ON post_vote
FOR EACH ROW
EXECUTE FUNCTION insert_post_notification_vote();


CREATE OR REPLACE FUNCTION insert_post_notification_comment()
RETURNS TRIGGER AS $$
DECLARE
    post_author INT;
BEGIN
    SELECT id_user INTO post_author FROM post WHERE id = NEW.id_post;

        INSERT INTO post_notification (id_post, type, id_user_notified, date, id_user_generator)
        VALUES (NEW.id_post, 'Comment_on_Post', post_author, CURRENT_TIMESTAMP, NEW.id_user);
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER post_comment_notification_trigger
AFTER INSERT ON comment
FOR EACH ROW
EXECUTE FUNCTION insert_post_notification_comment();



CREATE OR REPLACE FUNCTION insert_post_notification_for_followers()
RETURNS TRIGGER AS $$
DECLARE
    follower RECORD;
BEGIN
    FOR follower IN
        SELECT id_user_follower FROM follows WHERE id_user_followed = NEW.id_user
    LOOP
        INSERT INTO post_notification (id_post, type, id_user_notified, date, id_user_generator)
        VALUES (NEW.id, 'Followed_user_posted', follower.id_user_follower, CURRENT_TIMESTAMP, NEW.id_user);
    END LOOP;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER post_follow_notification_trigger
AFTER INSERT ON post
FOR EACH ROW
EXECUTE FUNCTION insert_post_notification_for_followers();

CREATE OR REPLACE FUNCTION insert_comment_notification()
RETURNS TRIGGER AS $$
DECLARE
    comment_author INT;
BEGIN
    SELECT id_user INTO comment_author FROM comment WHERE id = NEW.id_comment;

    IF NEW.upvote_bool = TRUE THEN
        IF NOT EXISTS (
            SELECT 1
            FROM comment_notification
            WHERE id_comment = NEW.id_comment
              AND id_user_generator = NEW.id_user
              
        ) THEN
            INSERT INTO comment_notification (id_comment, id_user_notified, id_user_generator)
            VALUES (NEW.id_comment, comment_author, NEW.id_user);
        END IF;
    END IF;
    
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER comment_notification_trigger
AFTER INSERT ON comment_vote
FOR EACH ROW
EXECUTE FUNCTION insert_comment_notification();



CREATE OR REPLACE FUNCTION update_post_author_reputation_on_vote()
RETURNS TRIGGER AS $$
DECLARE
    post_author_id INT;
BEGIN
    SELECT id_user INTO post_author_id FROM post WHERE id = NEW.id_post;

    IF NEW.upvote_bool = TRUE THEN
        UPDATE users SET reputation = reputation + 5 WHERE id = post_author_id;
    ELSE
        UPDATE users SET reputation = reputation - 5 WHERE id = post_author_id;
    END IF;
    
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER update_author_reputation_on_vote
AFTER INSERT ON post_vote
FOR EACH ROW
EXECUTE FUNCTION update_post_author_reputation_on_vote();

CREATE OR REPLACE FUNCTION adjust_post_author_reputation_on_vote_removal()
RETURNS TRIGGER AS $$
DECLARE
    post_author_id INT;
BEGIN
    SELECT id_user INTO post_author_id FROM post WHERE id = OLD.id_post;

    IF OLD.upvote_bool = TRUE THEN
        UPDATE users SET reputation = reputation - 5 WHERE id = post_author_id;
    ELSE
        UPDATE users SET reputation = reputation + 5 WHERE id = post_author_id;
    END IF;
    
    RETURN OLD;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER adjust_author_reputation_on_vote_removal
AFTER DELETE ON post_vote
FOR EACH ROW
EXECUTE FUNCTION adjust_post_author_reputation_on_vote_removal();

CREATE OR REPLACE FUNCTION update_comment_author_reputation_on_vote()
RETURNS TRIGGER AS $$
DECLARE
    comment_author_id INT;
BEGIN
    SELECT id_user INTO comment_author_id FROM comment WHERE id = NEW.id_comment;

    IF NEW.upvote_bool = TRUE THEN
        UPDATE users SET reputation = reputation + 1 WHERE id = comment_author_id;
    ELSE
        UPDATE users SET reputation = reputation - 1 WHERE id = comment_author_id;
    END IF;
    
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER update_comment_author_reputation_on_vote
AFTER INSERT ON comment_vote
FOR EACH ROW
EXECUTE FUNCTION update_comment_author_reputation_on_vote();


CREATE OR REPLACE FUNCTION adjust_comment_author_reputation_on_vote_removal()
RETURNS TRIGGER AS $$
DECLARE
    comment_author_id INT;
BEGIN
    SELECT id_user INTO comment_author_id FROM comment WHERE id = OLD.id_comment;

    IF OLD.upvote_bool = TRUE THEN
        UPDATE users SET reputation = reputation - 1 WHERE id = comment_author_id;
    ELSE
        UPDATE users SET reputation = reputation + 1 WHERE id = comment_author_id;
    END IF;
    
    RETURN OLD;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER adjust_comment_author_reputation_on_vote_removal
AFTER DELETE ON comment_vote
FOR EACH ROW
EXECUTE FUNCTION adjust_comment_author_reputation_on_vote_removal();
