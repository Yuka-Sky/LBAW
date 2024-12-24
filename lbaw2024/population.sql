-- users
INSERT INTO users (name,email,password,reputation,is_admin) -- 1
VALUES ('iAmTheAdmin', 'admin@verykewl.com', 'notagoodpswdbro', 420, TRUE); 
INSERT INTO users (name,email,password,reputation,is_admin) -- 2
VALUES ('Antonio Antunes', 'tones@up.pt', '12d2ewqd', 16, FALSE);
INSERT INTO users (name,email,password,reputation,is_admin) -- 3
VALUES ('Afonso Fonseca', 'afonsofonseca@up.pt', 'dfqDWQ!', 99, FALSE);
INSERT INTO users (name,email,password,reputation,is_admin) -- 4
VALUES ('Bad Person', 'bad@up.pt', 'ndjada232', -10, FALSE);
INSERT INTO users (name,email,password,reputation,is_admin) -- 5
VALUES ('Terrible Person', 'verybad@up.pt', 'ndoajW3oi3', -50, FALSE);
INSERT INTO users (name,email,password,reputation,is_admin) -- 6
VALUES ('Margarida Flores', 'MRGRD@up.pt', 'marflores', 54, FALSE);
INSERT INTO users (name,email,password,reputation,is_admin) -- 7
VALUES ('zé', 'ze@ze.ze', 'ze', 2, FALSE);
INSERT INTO users (name,email,password,reputation,is_admin) -- 8
VALUES ('bestStudent', 'studentemail@up.pt', 'studentpassword', 26, FALSE);
INSERT INTO users (name,email,password,reputation,is_admin) -- 9
VALUES ('imnotfromfeup', 'iamfromfeup@up.pt', 'maybeiamfromfeup', 30, FALSE);
INSERT INTO users (name,email,password,reputation,is_admin) -- 10
VALUES ('up101010101', '101010101@up.pt', 'meowwoem', 19, FALSE);
INSERT INTO users (name,email,password,reputation,is_admin) -- 11
VALUES ('malcomportado1', 'soumau@up.pt', 'haha', -1000, FALSE);
INSERT INTO users (name,email,password,reputation,is_admin) -- 12
VALUES ('malcomportado2', 'muitomau@up.pt', 'hehe', -2000, FALSE);


-- post
INSERT INTO post (id_user,title,subtitle,content)    -- 1
VALUES (1, 'Greetings', 'From the Admin', 'Welcome everyone to Feup! If this is your first year here, I hope youre ready to start a new academic journey on the best faculty of Porto.              Olá a todos! Se este é o vosso primeiro ano aqui, espero que estejam prontos para começar uma nova jornada académica na melhor faculdade do Porto.');
INSERT INTO post (id_user,title,content)                   -- 2
VALUES (9, 'Workshop de Programação', 'Boa tarde a todos. Esta sexta-feira às 16:00, realizar-se-á um workshop de C++ na sala I121 que terá como objetivo ensinar aos participantes diferentes algoritmos a serem implementados nessa linguagem. A inscrição é gratuita e pode ser feita através deste link: https://link.pt.');
INSERT INTO post (id_user,title,subtitle,content)          -- 3
VALUES (6, 'Representante do Ano', 'LEIC3', 'Olá! VEnho por este meio informar que em breve serão as eleições do representante do ano e eu serei uma das candidatas. Peço-vos que votem em mim e eu terei o maior interesse em ser-vos útil. Cumprimentos, MarFlores.');
INSERT INTO post (id_user, title, subtitle, content) -- 4
VALUES (9, 'Aviso de Manutenção', NULL, 'Atenção! Amanhã, das 18:00 às 20:00, haverá uma manutenção na plataforma Moodle. Agradecemos a compreensão de todos.');
INSERT INTO post (id_user, title, subtitle, content)       -- 5
VALUES (1, 'Novo Recurso no SIGARRA', NULL, 'Olá a todos! A partir de hoje, podem consultar as avaliações diretamente pelo SIGARRA. Espero que este recurso facilite o acompanhamento do vosso progresso académico.');
INSERT INTO post (id_user, title, content)                 -- 6
VALUES (2, 'Hackathon FEUP 2024', 'Vem testar as tuas habilidades de programação num evento de 24 horas! Forma uma equipa e participa neste desafio onde vais resolver problemas reais de empresas de tecnologia. Inscrições abertas no link: https://hackathonfeup.pt.');
INSERT INTO post (id_user, title, subtitle, content)       -- 7
VALUES (7, 'Apresentação de Projeto Final', 'Engenharia Informática', 'A todos os alunos de LEIC2: não se esqueçam de submeter o vosso projeto final até ao dia 30 de Junho. Boa sorte a todos!');
INSERT INTO post (id_user, title, content)                 -- 8
VALUES (10, 'Aulas Extra de RCOM', 'Para todos que precisam de um reforço em RCOM, o Núcleo de Informática irá organizar sessões de apoio todas as sextas-feiras às 14h na sala I010. Inscrições no SIGARRA.');
INSERT INTO post (id_user, title, subtitle, content)       -- 9
VALUES (7, 'Apresentação de Projeto Final', 'Engenharia Informática', 'A todos os alunos de LEIC2: não se esqueçam de submeter o vosso projeto final até ao dia 30 de Junho. Boa sorte a todos!');
INSERT INTO post (id_user, title, content)                 -- 10
VALUES (10, 'Aulas Extra de RCOM', 'Para todos que precisam de um reforço em RCOM, o Núcleo de Informática irá organizar sessões de apoio todas as sextas-feiras às 14h na sala I010. Inscrições no SIGARRA.');

-- comment
INSERT INTO comment (id_user, id_post, content) -- 1
VALUES (2, 1, 'Obrigado pela recepção, admin! Pronto para começar!');
INSERT INTO comment (id_user, id_post, content) -- 2
VALUES (4, 2, 'Alguém sabe se vai ser presencial ou online?');
INSERT INTO comment (id_user, id_post, content)       -- 3
VALUES (6, 3, 'Margarida, conta com o meu voto!');
INSERT INTO comment (id_user, id_post, content)       -- 4
VALUES (9, 4, 'Espero que a manutenção termine a tempo. Tenho um trabalho para enviar.');
INSERT INTO comment (id_user, id_post, content) -- 5
VALUES (8, 5, 'Vai facilitar bastante! Obrigado pela atualização!');
INSERT INTO comment (id_user, id_post, content)       -- 6
VALUES (7, 6, 'Vou inscrever com dois amigos meus! Alguém quer se juntar?');
INSERT INTO comment (id_user, id_post, content)       -- 7
VALUES (3, 7, 'Alguém sabe qual é a sala para a apresentação dos projetos?');
INSERT INTO comment (id_user, id_post, content) -- 8
VALUES (10, 8, 'Precisava mesmo perceber melhor RCOM, obrigado!');
INSERT INTO comment (id_user, id_post, content)       -- 9
VALUES (5, 4, 'Ainda bem que avisaram sobre a manutenção. Estava a planear estudar a essa hora, já vou ter que fazer download das fichas para poder tê-las a essa hora.');
INSERT INTO comment (id_user, id_post, content)       -- 10
VALUES (1, 2, 'O workshop parece interessante. Mal posso esperar para ver os algoritmos!');

-- post_vote
INSERT INTO post_vote (id_user, id_post, upvote_bool)
VALUES 
(2, 1, TRUE),   -- Antonio Antunes deu um upvote no post de boas-vindas do admin
(3, 1, TRUE),   -- Afonso Fonseca deu um upvote no post de boas-vindas do admin
(4, 1, FALSE),  -- Bad Person deu um downvote no post de boas-vindas do admin
(5, 1, FALSE),  -- Terrible Person deu um downvote no post de boas-vindas do admin
(6, 1, TRUE),   -- Margarida Flores deu um upvote no post de boas-vindas do admin
(3, 2, FALSE),  -- Afonso Fonseca deu um downvote no post sobre o workshop
(2, 3, TRUE),   -- Antonio Antunes deu um upvote no post sobre as eleições de representante
(3, 3, TRUE),   -- Afonso Fonseca deu um upvote no post sobre as eleições de representante
(4, 3, TRUE),   -- Bad Person deu um upvote no post sobre as eleições de representante
(5, 3, TRUE),   -- Terrible Person deu um upvote no post sobre as eleições de representante
(7, 4, TRUE),   -- zé deu um upvote no aviso de manutenção do Moodle
(9, 5, TRUE),   -- imnotfromfeup deu um upvote no post sobre o novo recurso no SIGARRA
(10, 6, FALSE); -- up101010101 deu um downvote no post do hackathon

-- comment_vote
INSERT INTO comment_vote (id_user, id_comment, upvote_bool)
VALUES 
(8, 1, TRUE),   -- bestStudent deu um upvote no comentário do Antonio Antunes no post de boas-vindas do admin
(3, 1, TRUE),   -- Afonso Fonseca deu um upvote no comentário do Antonio Antunes no post de boas-vindas do admin
(4, 1, FALSE),  -- Bad Person deu um downvote no comentário do Antonio Antunes no post de boas-vindas do admin
(5, 2, FALSE),  -- Terrible Person deu um downvote no comentário sobre o workshop
(6, 3, TRUE),   -- Margarida Flores deu um upvote no comentário de apoio à candidatura
(3, 4, TRUE),   -- Afonso Fonseca deu um upvote no comentário sobre a manutenção do Moodle
(8, 4, TRUE),   -- bestStudent deu um upvote no comentário sobre a manutenção do Moodle
(2, 5, TRUE),   -- Antonio Antunes deu um upvote no comentário sobre o novo recurso do SIGARRA
(3, 5, TRUE),   -- Afonso Fonseca deu um upvote no comentário sobre o novo recurso do SIGARRA
(7, 6, TRUE),   -- zé deu um upvote no comentário sobre formar uma equipa para o hackathon
(9, 7, TRUE),   -- imnotfromfeup deu um upvote no comentário sobre a sala de entrega de projetos
(10, 8, FALSE); -- up101010101 deu um downvote no comentário sobre as aulas extra de RCOM

-- follows
INSERT INTO follows (id_user_follower, id_user_followed)
VALUES 
(2, 1),  -- Antonio Antunes segue o admin
(3, 1),  -- Afonso Fonseca segue o admin
(5, 1),  -- Terrible Person segue o admin
(9, 1),  -- imnotfromfeup segue o admin
(4, 2),  -- Bad Person segue Antonio Antunes
(6, 3),  -- Margarida Flores segue Afonso Fonseca
(10, 3), -- up101010101 segue Afonso Fonseca
(7, 4),  -- zé segue Bad Person
(1, 5),  -- iAmTheAdmin segue Terrible Person
(2, 6),  -- Antonio Antunes segue Margarida Flores
(3, 6),  -- Afonso Fonseca segue Margarida Flores
(4, 6),  -- Bad Person segue Margarida Flores
(5, 6),  -- Terrible Person segue Margarida Flores
(8, 6);  -- bestStudent segue Margarida Flores

-- tag
INSERT INTO tag (name)
VALUES 
('#AEFEUP'),      -- 1
('#Feupcafé'),    -- 2
('#LEIC'),        -- 3
('#LBIO'),        -- 4
('#CINF'),        -- 5
('#CC'),          -- 6
('#LAERO'),       -- 7
('#LEC'),         -- 8
('#LEM'),         -- 9
('#LEQ'),         -- 10
('#LIACD'),       -- 11
('#LEF'),         -- 12
('#LEEC'),        -- 13
('#LEGI'),        -- 14
('#LEMAT'),       -- 15
('#LEMG'),        -- 16
('#LEA'),         -- 17
('#LGBTQIA+'),    -- 18
('#CareerFair'),  -- 19
('#Workshops'),   -- 20
('#Eventos'),     -- 21
('#Eleições'),    -- 22
('#alunos'),      -- 23
('#professores'), -- 24
('#Moodle'),      -- 25
('#SIGARRA'),     -- 26
('#Serviços'),    -- 27
('#Programação'), -- 28
('#Site'),        -- 29
('#FEUP');        -- 30

-- post_tag
INSERT INTO post_tag (id_post, id_tag)
VALUES 
(1, 23),  -- Post de boas-vindas do admin com tag #alunos
(1, 30),  -- Post de boas-vindas do admin com tag #FEUP
(2, 20),  -- Post sobre o workshop com tag #Workshops
(2, 26),  -- Post sobre o workshop com tag #SIGARRA
(2, 28),  -- Post sobre o workshop com tag #Programação
(3, 5),   -- Post sobre as eleições de representante com tag #CINF
(3, 22),  -- Post sobre as eleições de representante com tag #Eleições
(4, 6),   -- Aviso de manutenção no Moodle com tag #CC
(4, 25),  -- Aviso de manutenção no Moodle com tag #Moodle
(5, 7),   -- Post sobre novo recurso no SIGARRA com tag #LAERO
(5, 25),  -- Post sobre novo recurso no SIGARRA com tag #Moodle
(6, 23),  -- Post sobre o hackathon com tag #alunos
(6, 21),  -- Post sobre o hackathon com tag #Eventos
(7, 12),  -- Post sobre a reunião com professores com tag #LEF
(8, 23),  -- Post sobre apoio a alunos com tag #alunos
(9, 24),  -- Post sobre apoio a professores com tag #professores
(10, 27), -- Post sobre serviços na faculdade com tag #Serviços
(10, 28); -- Post sobre programação na faculdade com tag #Programação

-- blocks
INSERT INTO blocks (id_user_blocker, id_user_blocked)
VALUES (1, 11);  -- admin bloqueia malcomportado1

-- ban
INSERT INTO ban (id_user, id_admin, reason, permanent_bool, begin_date, end_date)
VALUES 
(12, 1, 'Comportamento agressivo', TRUE, '2024-01-01 00:00:00', '2025-01-01 00:00:00'),  -- malcomportado2 banido permanentemente
(11, 1, 'Comportamento inadequado', FALSE, '2024-01-05 00:00:00', '2024-02-05 00:00:00');  -- malcomportado1 banido temporariamente

