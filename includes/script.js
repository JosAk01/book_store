function openEditModal(bookId) {
  // Populate and show the edit modal
  const form = document.getElementById(`editForm-${bookId}`);
  document.getElementById('editModal').style.display = 'block';
  document.getElementById('editFormContent').innerHTML = form.innerHTML;
  document.getElementById('editFormContent').dataset.bookId = bookId;
}

function closeEditModal() {
  document.getElementById('editModal').style.display = 'none';
}

function openDeleteModal(bookId) {
  // Show the delete modal
  document.getElementById('deleteModal').style.display = 'block';
  document.getElementById('deleteConfirm').dataset.bookId = bookId;
}

function closeDeleteModal() {
  document.getElementById('deleteModal').style.display = 'none';
}

function confirmDelete() {
  const bookId = document.getElementById('deleteConfirm').dataset.bookId;
  const form = document.getElementById(`deleteForm-${bookId}`);
  const formData = new FormData(form);

  fetch('handleActions.php', {
      method: 'POST',
      body: formData
  }).then(response => response.text()).then(result => {
      alert('Book deleted');
      closeDeleteModal();
      location.reload(); // Reload to reflect the changes
  }).catch(error => {
      console.error('Error:', error);
  });
}

document.getElementById('editSave').addEventListener('click', function() {
  const bookId = document.getElementById('editFormContent').dataset.bookId;
  const form = document.getElementById(`editForm-${bookId}`);
  const formData = new FormData(form);

  fetch('handleActions.php', {
      method: 'POST',
      body: formData
  }).then(response => response.text()).then(result => {
      alert('Book details updated');
      closeEditModal();
      location.reload(); // Reload to reflect the changes
  }).catch(error => {
      console.error('Error:', error);
  });
});

// Close the modal when clicking outside of it
window.onclick = function(event) {
  const editModal = document.getElementById('editModal');
  const deleteModal = document.getElementById('deleteModal');
  if (event.target == editModal) {
      editModal.style.display = "none";
  }
  if (event.target == deleteModal) {
      deleteModal.style.display = "none";
  }
}

function openEditModal(title, description, author, publication_year, country, company, price, barcode, isbn, languages, image, id) {
  document.getElementById('edit-book-id').value = id;
  document.getElementById('edit-title').value = title;
  document.getElementById('edit-description').value = description;
  document.getElementById('edit-author').value = author;
  document.getElementById('edit-publication_year').value = publication_year;
  document.getElementById('edit-country').value = country;
  document.getElementById('edit-company').value = company;
  document.getElementById('edit-price').value = price;
  document.getElementById('edit-barcode').value = barcode;
  document.getElementById('edit-isbn').value = isbn;
  document.getElementById('edit-languages').value = languages;
  document.getElementById('edit-image').value = image;
  document.getElementById('editModal').style.display = 'block';
}

function closeEditModal() {
  document.getElementById('editModal').style.display = 'none';
}

function openDeleteModal(id) {
  document.getElementById('delete-book-id').value = id;
  document.getElementById('deleteModal').style.display = 'block';
}

function closeDeleteModal() {
  document.getElementById('deleteModal').style.display = 'none';
}

function openEditModal(title, description, author, publication_year, country, company, price, barcode, isbn, languages, image, id) {
  document.getElementById('edit-book-id').value = id;
  document.getElementById('edit-title').value = title;
  document.getElementById('edit-description').value = description;
  document.getElementById('edit-author').value = author;
  document.getElementById('edit-publication_year').value = publication_year;
  document.getElementById('edit-country').value = country;
  document.getElementById('edit-company').value = company;
  document.getElementById('edit-price').value = price;
  document.getElementById('edit-barcode').value = barcode;
  document.getElementById('edit-isbn').value = isbn;
  document.getElementById('edit-languages').value = languages;
  document.getElementById('edit-image-path').value = imagePath;
  document.getElementById('editModal').style.display = 'block';

  // Display existing image path
  document.getElementById('edit-image-preview').src = imagePath;
  document.getElementById('edit-image-preview').style.display = 'block';
}

function previewImage(input) {
  const preview = document.getElementById('edit-image-preview');
  const file = input.files[0];
  const reader = new FileReader();

  reader.onload = function(e) {
      preview.src = e.target.result;
  }

  if (file) {
      reader.readAsDataURL(file);
  } else {
      preview.src = '#';
  }
}

// Rest of your JavaScript code...
