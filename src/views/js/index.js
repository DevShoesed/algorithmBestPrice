$(function () {
  fetch("/airport")
    .then((data) => {
      console.log(data.body);
    })
    .catch((e) => {
      console.error(e);
    });
});
