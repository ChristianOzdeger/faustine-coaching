// déclaration du module app
let app = {
  reverse: function() {
    let mail = document.getElementById('contact-mail');
    mail.textContent = (mail.textContent).split('').reverse().join('');
  }

};

app.reverse();