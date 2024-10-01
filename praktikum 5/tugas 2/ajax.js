function createXHR() {
  if (window.XMLHttpRequest) {
    return new XMLHttpRequest(); // For modern browsers
  } else {
    return new ActiveXObject("Microsoft.XMLHTTP"); // For old IE
  }
}

function searchBook(title) {
  var xhr = createXHR();

  if (title.length === 0) {
    document.getElementById("book_details").innerHTML = ""; // Clear results if input is empty
    return;
  }

  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      document.getElementById("book_details").innerHTML = xhr.responseText;
    }
  };

  xhr.open(
    "GET",
    "get_book_detail.php?title=" + encodeURIComponent(title),
    true
  );
  xhr.send();
}
