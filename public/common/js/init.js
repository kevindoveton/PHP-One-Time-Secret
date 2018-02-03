const clipboard = new Clipboard('[data-clipboard-target]');
clipboard.on('success', function (e) {
  e.clearSelection();
  const copied = document.querySelector('.copied');
  copied.style.display = 'block';
  setTimeout(() => {
    copied.style.opacity = 1;
  }, 100);

  setTimeout(() => {
    copied.style.opacity = 0;
    setTimeout(() => {
      copied.style.display = 'none';
    }, 500);
  }, 3000);
});


function processForm() {
  const url = window.location.href;
  console.log(url);
  fetch(url, {
    method: 'POST',
    body: JSON.stringify({
      password: document.querySelector('[name="password"]').value
    }),
    headers: new Headers({
      'Content-Type': 'application/json'
    })
  }).then((response) => {
    console.log(response)
    return response.json();
  }).then((d) => {
    const l = window.location;
    const port = l.port == '' ? '' : ':' + l.port;
    const host = l.protocol + '//' + l.hostname + port;
    const url = host + d.url;

    document.querySelector('.url .value').innerHTML = url;
    document.querySelector('.form').style.display = 'none';
    document.querySelector('.url').style.display = 'block';
  });

}
