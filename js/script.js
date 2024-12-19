const firebaseConfig = {
  apiKey: "AIzaSyBWJPJFlRwRo63R0uH23ub9vCbcaDAFXDA",
  authDomain: "dt-otp.firebaseapp.com",
  projectId: "dt-otp",
  storageBucket: "dt-otp.firebasestorage.app",
  messagingSenderId: "169050036008",
  appId: "1:169050036008:web:64d8903cff9fa94fe3221d",
  measurementId: "G-T17WKN7VH0"
};

// Initialize Firebase
firebase.initializeApp(firebaseConfig);

// Render the reCAPTCHA verifier
function render() {
  window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
      'size': 'normal',
      'callback': function(response) {
          console.log("reCAPTCHA solved, you can proceed with phone number verification.");
      },
      'expired-callback': function() {
          console.log("reCAPTCHA expired, please solve it again.");
      }
  });
  recaptchaVerifier.render();
}

// Send OTP
document.getElementById('sendOtpBtn').onclick = function() {
  var phoneNumber = document.getElementById('phone').value;
  var appVerifier = window.recaptchaVerifier;

  firebase.auth().signInWithPhoneNumber(phoneNumber, appVerifier)
      .then(function(confirmationResult) {
          window.confirmationResult = confirmationResult;
          document.querySelector('.number-input').style.display = 'none';
          document.querySelector('.otp-verification').style.display = 'block';
          console.log("OTP sent successfully.");
      })
      .catch(function(error) {
          console.error("Error during signInWithPhoneNumber", error);
          alert(error.message);
      });
};

// Verify OTP
document.getElementById('verifyOtpBtn').onclick = function() {
  var code = document.getElementById('verificationCode').value;
  window.confirmationResult.confirm(code)
      .then(function(result) {
          document.querySelector('.otp-verification').style.display = 'none';
          // Sau khi OTP đã được xác nhận, kích hoạt nút đăng nhập để kiểm tra số điện thoại và chuyển hướng
          document.getElementById('loginBtn').click();
      })
      .catch(function(error) {
          document.getElementById('otpErrorMessage').style.display = 'block';
          console.error("Error during OTP verification", error);
      });
};

// Render reCAPTCHA on page load
window.onload = function() {
  render();
};
