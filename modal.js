//The modal works with or without a button.
//You can simply add the button to the HTML and then comment out,
// the function that displays the modal with a delay.

// Ensure DOM is fully loaded before running the script

document.addEventListener("DOMContentLoaded", function () {
  const modal = document.querySelector(".custom-modal");
  //const modalBtn = document.querySelector(".modal-btn");
  const closeBtn = document.querySelector(".custom-close-btn");

  function myModal() {
    modal.style.display = "block"; // Show the modal
    // const message = document.querySelector("#modalMessage");
  }

  // Call myModal after a 1.5-second delay
  setTimeout(myModal, 1500);

  // Add event listener to the close X character of the modal
  closeBtn.addEventListener("click", function () {
    modal.style.display = "none";
  });

  // Add event listener to the window to close modal on outside click
  window.addEventListener("click", function (event) {
    if (event.target === modal) {
      modal.style.display = "none";
    }
  });
});
