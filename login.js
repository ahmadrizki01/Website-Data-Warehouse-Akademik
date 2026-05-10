const email=document.getElementById('exampleInputEmail1');
const password=document.getElementById('exampleInputPassword1');

const signin =document.getElementById('sign-in');

signin.addEventListener('click', function (e) {
    e.preventDefault();
  if( email.value === "" || password.value === ""){
    alert('Email dan Password Wajib diisi')
        return;

        
   
  }
  window.location.href="index.html" 
})