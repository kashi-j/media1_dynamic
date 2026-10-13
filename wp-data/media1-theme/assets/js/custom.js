window.addEventListener("click", () => {
  customHtmlSize();
});

function customHtmlSize() {
  const textArea = document.querySelectorAll(
    "textarea.block-editor-plain-text"
  );

  textArea.forEach((el) => {
    const h = parseInt(el.style.height);
    if (Number.isInteger(h)) {
      if (h > 250) {
        el.style.maxHeight = `${h}px`;
      }
    }
  });
}