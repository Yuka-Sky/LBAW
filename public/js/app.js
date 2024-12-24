function encodeForAjax(data) {
  if (data == null) return null;
  return Object.keys(data).map(function(k){
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&');
}

function sendAjaxRequest(method, url, data, handler) {
  let request = new XMLHttpRequest();

  request.open(method, url, true);
  request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  request.addEventListener('load', handler);
  request.send(encodeForAjax(data));
}

// DOM-dependent code
document.addEventListener('DOMContentLoaded', function () {

//filters menu 
const filtersBtn = document.getElementById('filters-btn');
const closeFiltersBtn = document.getElementById('close-filters-btn');
const filtersOverlay = document.getElementById('filters-overlay');
if( filtersBtn){
    filtersBtn.addEventListener('click', () => {
      filtersOverlay.style.display = 'block'; // Show overlay
    });
}
if( closeFiltersBtn){
    closeFiltersBtn.addEventListener('click', () => {
      filtersOverlay.style.display = 'none'; // Hide overlay
    });
}
if(filtersOverlay){
    // Optional: Close overlay by clicking outside of the menu
    filtersOverlay.addEventListener('click', (event) => {
        if (event.target === filtersOverlay) {
          filtersOverlay.style.display = 'none';
        }
    });
}

//User Credentials edit profile

const editProfile = document.getElementById('editProfile');
if( editProfile){
  editProfile.addEventListener('submit', function(event){
    let isValid = true;
    
    // Validate Username
    const editedName = document.getElementById('name');
    const editedNameError = document.getElementById("editedNameError");
    if (editedName.value.length < 3 || editedName.value.length > 50) {
      editedNameError.style.display = "inline";
      isValid = false;
    } else {
      editedNameError.style.display = "none";
    }
    // Validate email
    const editedEmail = document.getElementById('email');
    const editedEmailError = document.getElementById("editedEmailError");
    if (editedEmail.value.length > 100) {
      editedEmailError.style.display = "inline";
      isValid = false;
    } else {
      editedEmailError.style.display = "none";
    }
    if (!isValid) {
      event.preventDefault();
    }
  });
  
}

// Registration 
const registrationFormElement = document.getElementById('registrationForm');
if (registrationFormElement){
  registrationFormElement.addEventListener('submit', function(event) {  
    let isValid = true;
    // Validate Username
    const username = document.getElementById("name");
    const usernameError = document.getElementById("usernameError");
    if (username.value.length < 3 || username.value.length > 50) {
      usernameError.style.display = "inline";
      isValid = false;
    } else {
      usernameError.style.display = "none";
    }
    //Validate password
    const password = document.getElementById("password");
    const passwordError = document.getElementById("passwordError");
    if (password.value.length < 8) {
      passwordError.style.display = "inline";
      isValid = false;
    } else {
      passwordError.style.display = "none";
    }
    //Validate password confirmation
    const passwordconfirm = document.getElementById("password-confirm");
    const confirmpasswordError = document.getElementById("confirmpasswordError");
    if (passwordconfirm.value !== password.value) {
      confirmpasswordError.style.display = "inline";
      isValid = false;
    } else {
      confirmpasswordError.style.display = "none";
    }
    // Prevent form submission if validation fails
    if (!isValid) {
      event.preventDefault();
    }
  });
  // real-time password confirmation
  
  const password = document.getElementById("password");
  password.addEventListener('keyup', function(event) {  // document.getElementById('postForm')
    const passwordError = document.getElementById("passwordError");
    if (password.value.length > 0 & password.value.length < 8) {
      passwordError.style.display = "inline";
      isValid = false;
    } else {
      passwordError.style.display = "none";
    }
    
    const passwordconfirm = document.getElementById("password-confirm");
    const confirmpasswordError = document.getElementById("confirmpasswordError");
    if (passwordconfirm.value.length > 0 & passwordconfirm.value !== password.value) {
      confirmpasswordError.style.display = "inline";
      isValid = false;
    } else {
      confirmpasswordError.style.display = "none";
    }
  });
  
  const passwordconfirm = document.getElementById("password-confirm");
  passwordconfirm.addEventListener('keyup', function(event) {  // document.getElementById('postForm')
    const confirmpasswordError = document.getElementById("confirmpasswordError");
    if (passwordconfirm.value.length > 0 & passwordconfirm.value !== password.value) {
      confirmpasswordError.style.display = "inline";
      isValid = false;
    } else {
      confirmpasswordError.style.display = "none";
    }
  });
}

//Post form 
const postFormElement = document.getElementById('postForm');
if (postFormElement){
  postFormElement.addEventListener('submit', function(event) {  // document.getElementById('postForm')

    let title = document.getElementById('title');
    let content = document.getElementById('post-content');
    let isValid = true;

        // Basic validation example
    if (title.value.length > 100) {
      isValid = false;
      alert('Título demasiado longo');
    }

    if (content.value.length > 2000) {
      isValid = false;
      alert('Conteúdo demasiado longo');
    }

    if (!isValid) {
      event.preventDefault();
    }
  });
}
   
const titleElement = document.getElementById('title');
if (titleElement){
  titleElement.addEventListener('input', function() { //document.getElementById('title')
    const maxLength = 100;
    const currentLength = this.value.length;
    const charCountElement = document.getElementById('charCount');
      if (charCountElement) {
        const diffLength = maxLength - currentLength;
        if(diffLength < 0){
          charCountElement.style.color = 'red';
          charCountElement.innerText = `Limite ultrapassado em ${diffLength * (-1)} caracteres.`;
        }
        else{
          charCountElement.style.color = 'black';
          charCountElement.innerText = `Restam ${diffLength} caracteres.`;
        }
      }
  });
}

const subtitleElement = document.getElementById('subtitle');
if (subtitleElement){
  subtitleElement.addEventListener('input', function() { //document.getElementById('title')
    const maxLength = 100;
    const currentLength = this.value.length;
    const charCountElement = document.getElementById('charCountSub');
      if (charCountElement) {
        const diffLength = maxLength - currentLength;
        if(diffLength < 0){
          charCountElement.style.color = 'red';
          charCountElement.innerText = `Limite ultrapassado em ${diffLength * (-1)} caracteres.`;
        }
        else{
          charCountElement.style.color = 'black';
          charCountElement.innerText = `Restam ${diffLength} caracteres.`;
        }
      }
  });
}
  
const postContentElement = document.getElementById('post-content');
if (postContentElement){
  postContentElement.addEventListener('input', function() { // document.getElementById('post-content')
    const maxLength = 2000;
    const currentLength = this.value.length;
    const charCountElement = document.getElementById('charCountCont');
      if (charCountElement) {
        const diffLength = maxLength - currentLength;
        if((diffLength) < 0){
          charCountElement.style.color = 'red';
          charCountElement.innerText = `Limite ultrapassado em ${diffLength * (-1)} caracteres.`;
        }
        else{
          charCountElement.style.color = 'black';
          charCountElement.innerText = `Restam ${diffLength} caracteres.`;
        }
      }
  });
}

// Comment content character countdown
const commentContentElement = document.getElementById('comment-content');
if (commentContentElement) {
  commentContentElement.addEventListener('input', function () {
    const maxLength = 1000; // Maximum character limit for comments
    const currentLength = this.value.length; // Current character count
    const charCountElement = document.getElementById('charCountCom'); // Character count display element
    if (charCountElement) {
      const diffLength = maxLength - currentLength;
      if((diffLength) < 0){
        charCountElement.style.color = 'red';
        charCountElement.innerText = `Limite ultrapassado em ${diffLength * (-1)} caracteres.`;
      }
      else{
        charCountElement.style.color = 'black';
        charCountElement.innerText = `Restam ${diffLength} caracteres.`;
      }
    }
  });
}


const searchBar = document.getElementById('search-input');
if (searchBar){
  searchBar.addEventListener('keyup', function(event) {
    let query = this.value;
    let encodedQuery = encodeURIComponent(query);
    let resultsContainer = document.getElementById('search-results');
    const searchError = document.getElementById("searchError");
    if(query.length > 200){
      searchError.style.display = "inline";
      event.preventDefault();
    }
    else{
      searchError.style.display = "none";
      if (query.length === 0){
        resultsContainer.innerHTML = '';
      }
      //console.log(encodedQuery);
      if (query.length > 2) { // Perform search only if query is longer than 2 characters
        fetch(`/posts/search?query=${encodedQuery}`)
          .then(response => response.text())  // Change to 'response.text()' because its receiving HTML
          .then(data => {
            //let resultsContainer = document.getElementById('search-results');
            resultsContainer.innerHTML = '';  // Clear previous results

            // Append the new HTML content to the results container
            resultsContainer.innerHTML = data;  // Directly inject the returned HTML (search results)
          })
          .catch(error => console.error('Error:', error));
      }
    }
    
  });
}

// Posts vote

  // Delegate event listener for upvote and downvote buttons
  document.body.addEventListener('click', function (event) {
    // Check if a vote button was clicked
    if (event.target.classList.contains('vote-btn')) {
      const button = event.target;

      // Get necessary data from the button
      const postId = button.getAttribute('data-post-id');
      const voteType = button.getAttribute('data-vote-type');
      const form = button.closest('form');

      if (!postId || !voteType || !form) {
        console.error('Missing required attributes or form for vote button.');
        return;
      }

      // Extract the CSRF token from the form
      const csrfToken = form.querySelector('input[name="_token"]').value;

      // Send AJAX request
      fetch(form.action, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({
          id_post: postId,
          vote_type: voteType,
        }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            updateVoteUI(postId, data);
          } else {
            console.error('Vote action failed:', data.message);
          }
        })
        .catch((error) => console.error('Error:', error));
    }
  });


// Function to update vote UI
function updateVoteUI(postId, data) {
  const upvoteBtn = document.querySelector(`button[data-post-id="${postId}"][data-vote-type="upvote"]`);
  const downvoteBtn = document.querySelector(`button[data-post-id="${postId}"][data-vote-type="downvote"]`);
  
  // Update the button states (colors and styles)
  if (data.upvoted) {
    upvoteBtn.classList.add('on');
    downvoteBtn.classList.remove('on');
  } else if (data.downvoted) {
    downvoteBtn.classList.add('on');
    upvoteBtn.classList.remove('on');
  } else {
    upvoteBtn.classList.remove('on');
    downvoteBtn.classList.remove('on');
  }
  
  // Update the vote counts (increment or decrement)
  const upvoteCountElement = document.querySelector(`#vote-counts-${postId} .upvote-count`);
  const downvoteCountElement = document.querySelector(`#vote-counts-${postId} .downvote-count`);
  
  if (data.upvoted) {
    upvoteCountElement.textContent = `${data.upvote_count}`;
    downvoteCountElement.textContent = `${data.downvote_count}`;
  } else if (data.downvoted) {
    upvoteCountElement.textContent = `${data.upvote_count}`;
    downvoteCountElement.textContent = `${data.downvote_count}`;
  } else {
    upvoteCountElement.textContent = `${data.upvote_count}`;
    downvoteCountElement.textContent = `${data.downvote_count}`;
  }
}

// Comments

  // Event listener for upvote and downvote buttons
  const voteButtons1 = document.querySelectorAll('.comment-vote-btn');

  voteButtons1.forEach(button => {
    button.addEventListener('click', function () {
      // Prevent the form submission
      const commentId = this.getAttribute('data-comment-id');
      const voteType = this.getAttribute('data-vote-type');
      
      // Send AJAX request to the backend
      fetch(`/comments/vote`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            id_comment: commentId,
            vote_type: voteType
        })
      })
      .then(response => response.json())
      .then(data => {
        // Update the UI based on the response
        if (data.success) {
          updateCommentVoteUI(commentId, data);
        }
      })
      .catch(error => console.error('Error:', error));
    });
  });


// Function to update vote UI
function updateCommentVoteUI(commentId, data) {
  const upvoteBtn = document.querySelector(`button[data-comment-id="${commentId}"][data-vote-type="upvote"]`);
  const downvoteBtn = document.querySelector(`button[data-comment-id="${commentId}"][data-vote-type="downvote"]`);
  
  // Update the button states (colors and styles)
  if (data.upvoted) {
    upvoteBtn.classList.add('on');
    downvoteBtn.classList.remove('on');
  } else if (data.downvoted) {
    downvoteBtn.classList.add('on');
    upvoteBtn.classList.remove('on');
  } else {
    upvoteBtn.classList.remove('on');
    downvoteBtn.classList.remove('on');
  }
  
  // Update the vote counts (increment or decrement)
  const upvoteCountElement = document.querySelector(`#comment-vote-counts-${commentId} .upvote-count`);
  const downvoteCountElement = document.querySelector(`#comment-vote-counts-${commentId} .downvote-count`);
  
  if (data.upvoted) {
    upvoteCountElement.textContent = `${data.upvote_count}`;
    downvoteCountElement.textContent = `${data.downvote_count}`;
  } else if (data.downvoted) {
    upvoteCountElement.textContent = `${data.upvote_count}`;
    downvoteCountElement.textContent = `${data.downvote_count}`;
  } else {
    upvoteCountElement.textContent = `${data.upvote_count}`;
    downvoteCountElement.textContent = `${data.downvote_count}`;
  }
}

// Delete Account By Admin

  document.querySelectorAll('.anonymize-button').forEach(button => {
        button.addEventListener('click', function () {
            const userId = this.getAttribute('data-user-id'); 
            const form = document.getElementById(`anonymize-account-form-${userId}`);
            const formAction = form.getAttribute('action');

            if (confirm('Tem certeza de que deseja apagar esta conta? Esta ação não pode ser desfeita.')) {
                fetch(formAction, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: new FormData(form)
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message); 
                    this.closest('li').remove();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ocorreu um erro ao apagar a conta.');
                });
            }
        });
    });


// Delete Own Account

  const anonymizeButton = document.getElementById('anonymize-account-button');
  if (anonymizeButton) {
    anonymizeButton.addEventListener('click', function () {
      if (confirm('Tem certeza de que deseja apagar a tua conta? Esta ação não pode ser desfeita.')) {
        document.getElementById('anonymize-account-form').submit();
      }
    });
  }

  const loadMoreBtn = document.getElementById('load-more');
  const postContainer = document.getElementById('post-container');
  if (loadMoreBtn) {
    loadMoreBtn.addEventListener('click', function () {
      const nextPageUrl = loadMoreBtn.getAttribute('data-next-page');
      console.log(nextPageUrl);
      if (nextPageUrl) {
        fetch(nextPageUrl, {
          headers: {
              'X-Requested-With': 'XMLHttpRequest',
          }
        })
        .then(response => response.json())
        .then(data => {
          postContainer.insertAdjacentHTML('beforeend', data.html);
          if (data.nextPage) {
            loadMoreBtn.setAttribute('data-next-page', data.nextPage);
          } else {
            loadMoreBtn.style.display = 'none';
          }
        })
        .catch(error => console.error('Error loading more posts:', error));
      }
    });
  }

document.addEventListener("DOMContentLoaded", () => {
  const tagsMenuToggle = document.getElementById("tagsMenuToggle");
  const tagsMenu = document.getElementById("tagsMenu");
  if (tagsMenu && tagsMenuToggle) {
    // Abrir o menu ao passar o mouse
    tagsMenuToggle.addEventListener("mouseenter", () => {
      tagsMenu.classList.remove("hidden");
      tagsMenu.classList.add("show");
    });


    tagsMenu.addEventListener("mouseleave", () => {
      tagsMenu.classList.add("hidden");
      tagsMenu.classList.remove("show");
    });
    
  }
});


  // Attach the cancel confirmation event
  document.body.addEventListener('click', function (event) {
    if (event.target && event.target.classList.contains('cancel-btn')) {
      event.preventDefault();    
      const cancelUrl = event.target.getAttribute('data-cancel-url');
      if (confirm('Tem certeza de que deseja cancelar? Todas as alterações serão perdidas.')) {
        if (cancelUrl) {
          window.location.href = cancelUrl;
        } else {
          console.error('Cancel URL is missing.');
        }
      }
    }
  });

  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  
  const addTagButton = document.getElementById('add-tag-button');
  const tagInput = document.getElementById('tag-input');
  if(addTagButton){
    addTagButton.addEventListener('click', function () {
      // Show the input field to add a new tag
      tagInput.style.display = 'inline-block';
      tagInput.focus();
    });
  }
  
  if(tagInput){
    tagInput.addEventListener('keypress', function (e) {
      if (e.key === 'Enter') {
        const tagName = tagInput.value.trim();
        if (tagName) {
          fetch('/tags', {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': csrfToken,
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({ name: tagName }),
          })
          .then(response => response.json())
          .then(data => {
            if (data.tag) {
              // Add new tag to the list
              const newTag = document.createElement('li');
                newTag.id = `tag-${data.tag.id}`;
                newTag.className = 'tag-item';
                newTag.innerHTML = `
                  #${data.tag.name}
                  <button class="btn btn-danger delete-tag-button" data-tag-id="${data.tag.id}">X</button>
                `;
                document.getElementById('tag-list').appendChild(newTag);
                attachDeleteEvent(newTag.querySelector('.delete-tag-button'));
                alert(data.message);
            }
            tagInput.value = '';
            tagInput.style.display = 'none';
          })
          .catch(error => {
            console.error('Error:', error);
            alert('Uma tag com esse nome já existe.');
          });
        }
      }
    });
  }
  
  // Delete Tag Buttons
  function attachDeleteEvent(button) {
    button.addEventListener('click', function () {
      const tagId = this.getAttribute('data-tag-id');
      if (confirm('Tem certeza de que deseja apagar esta tag?')) {
        fetch(`/tags/${tagId}`, {
          method: 'DELETE',
          headers: {
              'X-CSRF-TOKEN': csrfToken,
              'X-Requested-With': 'XMLHttpRequest'
          },
        })
        .then(response => response.json())
        .then(data => {
          if (data.message) {
              const tagElement = document.getElementById(`tag-${tagId}`);
              if (tagElement) tagElement.remove();
              alert(data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Ocorreu um erro ao apagar a tag.');
        });
      }
    });
  }

  document.querySelectorAll('.delete-tag-button').forEach(button => {
    attachDeleteEvent(button);
  });


});

document.addEventListener('DOMContentLoaded', function () {
  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  const promoteButtons = document.querySelectorAll('.promote-button');

  promoteButtons.forEach(button => {
    button.addEventListener('click', function () {
      const userId = this.getAttribute('data-user-id');
      const isAdmin = this.getAttribute('data-is-admin') === 'true';
      const url = `/user/${userId}/toggleAdmin`;

      fetch(url, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': csrfToken,
          'Content-Type': 'application/json'
          },
        body: JSON.stringify({})
      })
      .then(response => response.json())
      .then(data => {
          if (data.success) {
              // Update button text and status
              this.textContent = data.is_admin ? 'Despromover' : 'Promover';
              this.setAttribute('data-is-admin', data.is_admin);
              this.classList.toggle('btn-success', !data.is_admin);
              this.classList.toggle('btn-danger', data.is_admin);
          } else {
              alert(data.message || 'Erro ao alterar o status do utilizador.');
          }
      })
      .catch(error => {
          console.error('Erro:', error);
          alert('Erro ao processar a requisição.');
      });
    });
  });
});

document.querySelector('form').addEventListener('submit', function(event) {
  const endDateField = document.getElementById('end_date');
  if (!document.getElementById('permanent').checked && !endDateField.value) {
      alert('Please provide an end date for the temporary ban.');
      event.preventDefault();
  }
});

document.querySelectorAll('.ban-form').forEach(form => {
  form.addEventListener('submit', function (event) {
    event.preventDefault(); 

    const banButton = form.querySelector('button');
    const parentDiv = banButton.closest('#user_buttons');
    const userId = form.dataset.userId;

    fetch(form.action, {
      method: 'DELETE',
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      }
    })
    .then(response => {
        if (!response.ok) {
          throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
      if (data.message) {
        alert(data.message); 
        form.remove();
        const newButton = document.createElement('button');
        newButton.className = 'btn btn-danger admin-buttons';
        newButton.textContent = 'Banir';
        newButton.setAttribute(
          'onclick',
          `location.href='/ban/${userId}/create'` 
        );
        parentDiv.appendChild(newButton);
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Houve um erro ao tentar remover o ban.');
    });
  });
});

// Wait for the document to be ready
document.addEventListener("DOMContentLoaded", function() {
  // Get the form elements
  const passwordField = document.getElementById("password");
  const confirmPasswordField = document.getElementById("password-confirm");
  const submitButton = document.querySelector("form button");

  const passwordError = document.getElementById("passwordError");
  const confirmPasswordError = document.getElementById("confirmpasswordError");

  // Ensure elements exist before attaching event listeners
  if (passwordField && confirmPasswordField && submitButton && passwordError && confirmPasswordError) {
      // Add event listener for password validation
      passwordField.addEventListener("input", function() {
          if (passwordField.value.length < 8) {
              passwordError.style.display = "block";
          } else {
              passwordError.style.display = "none";
          }
      });

      // Add event listener for password confirmation validation
      confirmPasswordField.addEventListener("input", function() {
          if (confirmPasswordField.value !== passwordField.value) {
              confirmPasswordError.style.display = "block";
          } else {
              confirmPasswordError.style.display = "none";
          }
      });

      // Add event listener for form submission
      submitButton.addEventListener("click", function(event) {
          // Check if both fields are valid before submission
          if (passwordField.value.length < 8 || confirmPasswordField.value !== passwordField.value) {
              event.preventDefault(); // Prevent form submission
              if (passwordField.value.length < 8) {
                  alert("A palavra-passe deve ter pelo menos 8 caracteres.");
              }
              if (confirmPasswordField.value !== passwordField.value) {
                  alert("As palavras-passe não coincidem.");
              }
              return false; // Prevent form submission
          }

          // Confirm the password change before submitting
          const confirmation = confirm("Tem certeza de que deseja alterar a sua palavra-passe?");
          if (!confirmation) {
              event.preventDefault(); // Prevent form submission if user cancels
          }
      });
  }
});


function reloadPage() {
  location.reload();
}

document.addEventListener('DOMContentLoaded', function () {
  const editCommentForm = document.getElementById('edit-comment-form');
  if (editCommentForm) {
      editCommentForm.addEventListener('submit', function (event) {
          const content = document.getElementById('comment-content');
          if (content) {
              content.value = content.value.trim();
          }
      });
  }
});