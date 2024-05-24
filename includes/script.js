// document.addEventListener('DOMContentLoaded', function() {
  function openEditModal( title, description, author, publication_year, country, company, price, barcode, isbn, languages, image, id) {
    // console.log(title, description, author, publication_year, country, company, price, barcode, isbn, languages, imagePath, id);
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
      document.getElementById('edit-image-path').value = image;
      document.getElementById('editModal').style.display = 'block';

      // Display existing image
      document.getElementById('edit-image-preview').src = '../img/' + image;
      document.getElementById('edit-image-preview').style.display = 'block';
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

  function previewImage(input) {
      const preview = document.getElementById('edit-image-preview');
      const file = input.files[0];
      const reader = new FileReader();

      reader.onload = function(e) {
          preview.src = e.target.result;
          preview.style.display = 'block';
      }

      if (file) {
          reader.readAsDataURL(file);
      } else {
          preview.src = '#';
          preview.style.display = 'none';
      }
  }


  function editSaveBtn(){
    // alert()
          const bookId = document.getElementById('edit-book-id').value;
      const form = document.getElementById('editForm');
      const formData = new FormData(form);

      fetch('edit_book.php', {
          method: 'POST',
          body: formData
      }).then(response => response.text()).then(result => {
          alert('Book details updated');
          closeEditModal();
          location.reload(); // Reload to reflect the changes
      }).catch(error => {
          console.error('Error:', error);
          alert('E no dey work!')
      });
  }
  function deleteBtn(){
    const bookId = document.getElementById('delete-book-id').value;
      const form = document.getElementById('deleteForm');
      const formData = new FormData(form);

      fetch('delete_book.php', {
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
// });
