const table = document.getElementById("table");
const resizeHandles = document.querySelectorAll(".resize-handle");

resizeHandles.forEach((handle) => {
  let startX;
  let startWidth;

  handle.addEventListener("mousedown", (e) => {
    startX = e.pageX;
    startWidth = handle.parentElement.offsetWidth;

    document.addEventListener("mousemove", resizeColumn);
    document.addEventListener("mouseup", stopResize);
  });

  const resizeColumn = (e) => {
    const widthDiff = e.pageX - startX;
    const newWidth = startWidth + widthDiff;

    handle.parentElement.style.width = `${newWidth}px`;
  };

  const stopResize = () => {
    document.removeEventListener("mousemove", resizeColumn);
    document.removeEventListener("mouseup", stopResize);
  };
});


function RefreshTable(){
    const parent = document.querySelector('.active-table');
    const child = document.querySelectorAll('.resize-handle');
    child.style.height = `${parent.offsetHeight}px`;

}



