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

// Setup invisible reCAPTCHA
window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('sendOtpBtn', {
  'size': 'invisible',
  'callback': function(response) {
    // reCAPTCHA solved, allow signInWithPhoneNumber.
  },
  'expired-callback': function() {
    // Response expired. Ask user to solve reCAPTCHA again.
  }
});

function sendOTP() {
  var phoneNumber = document.getElementById('phone').value;
  // Sử dụng định dạng số điện thoại quốc tế
  var formattedPhoneNumber = "+84" + phoneNumber.replace(/^0/, '');

  var appVerifier = window.recaptchaVerifier;
  firebase.auth().signInWithPhoneNumber(formattedPhoneNumber, appVerifier)
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
}

function verifyOTP() {
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
}

document.getElementById('sendOtpBtn').onclick = sendOTP;
document.getElementById('verifyOtpBtn').onclick = verifyOTP;
