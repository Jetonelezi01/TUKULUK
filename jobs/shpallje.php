<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shpall Vendin e Punës</title>
    <style>
        /* Stilet për faqe */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            color: #333;
        }

        /* Kuti dhe formular */
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        label {
            font-size: 14px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="number"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        textarea {
            height: 100px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        /* Facebook login button */
        #login {
            text-align: center;
            margin: 20px;
        }

        #login button {
            background-color: #3b5998;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        #login button:hover {
            background-color: #2d4373;
        }

        /* Status message */
        #status {
            text-align: center;
            color: #666;
        }

        /* Success and Error messages */
        .message {
            padding: 10px;
            border-radius: 4px;
            text-align: center;
            margin-top: 20px;
        }

        .success {
            background-color: #4CAF50;
            color: white;
        }

        .error {
            background-color: #f44336;
            color: white;
        }

    </style>
</head>
<body>

    <div class="container">
        <div id="status">
            <p>Ju lutemi logohuni me Facebook për të shpallur një vend pune për biznesin tuaj. Pas logimit, ju mund të plotësoni të dhënat për vendin e punës që po shpallni.</p>
        </div>

        <!-- Facebook Login Button -->
        <div id="login">
            <fb:login-button scope="public_profile,email" onlogin="checkLoginState();">Login with Facebook</fb:login-button>
        </div>

        <!-- Form for job posting -->
        <div id="jobPostForm" style="display: none;">
            <h2>Shpall Vendin e Punës</h2>
            <form id="jobPostFormData" method="POST">
    <label for="business_name">Emri i Biznesit:</label>
    <input type="text" id="business_name" name="business_name" required><br>

    <label for="position">Pozita:</label>
    <input type="text" id="position" name="position" required><br>

    <label for="category">Kategoria:</label>
    <select id="category" name="category" required>
        <option value="Gaming">Gaming</option>
        <option value="Restorant">Restorant</option>
        <option value="Shishabar">Shishabar</option>
        <option value="Fastfood">Fastfood</option>
        <option value="Ujeinstalues">Ujeinstalues</option>
    </select><br>

    <label for="num_employees">Sa Puntor kërkoni:</label>
    <input type="number" id="num_employees" name="num_employees" required><br>

    <label for="salary">Pagesa në muaj:</label>
    <input type="number" id="salary" name="salary" step="0.01" required><br>

    <label for="work_hours">Sa Orë Punë:</label>
    <input type="number" id="work_hours" name="work_hours" required><br>

    <label for="comments">Koment:</label>
    <textarea id="comments" name="comments"></textarea><br>

    <label for="contact_number">Numri i Kontaktit:</label>
    <input type="text" id="contact_number" name="contact_number" required><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br>

    <input type="hidden" id="facebook_id" name="facebook_id">
    <button type="button" onclick="submitJobPost();">Shpalle Vendin</button>
</form>
        </div>

        <div id="responseMessage"></div>
    </div>

    <!-- Facebook SDK -->
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '2395519317446412',  // Vendosni ID-në tuaj të aplikacionit këtu
          cookie     : true,
          xfbml      : true,
          version    : 'v14.0'
        });

        FB.AppEvents.logPageView();   
      };

      (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));

      function checkLoginState() {
        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
                fetchFacebookProfile(response.authResponse.userID);
            } else {
                document.getElementById('status').innerHTML = 'Për të shpallur një vend pune, ju duhet të logohuni me Facebook.';
            }
        });
      }

      function fetchFacebookProfile(facebook_id) {
        FB.api('/me', {fields: 'name,email'}, function(response) {
            document.getElementById('status').style.display = 'none';  
            document.getElementById('login').style.display = 'none';  
            document.getElementById('jobPostForm').style.display = 'block';  

            document.getElementById('business_name').value = response.name;
            document.getElementById('email').value = response.email;
            document.getElementById('facebook_id').value = facebook_id;  
        });
      }

      function submitJobPost() {
        var formData = new FormData(document.getElementById('jobPostFormData'));
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "save_post.php", true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                document.getElementById('responseMessage').innerHTML = '<div class="message success">Shpallja u ruajt me sukses!</div>';
                document.getElementById('jobPostForm').reset();
            } else {
                document.getElementById('responseMessage').innerHTML = '<div class="message error">Ka ndodhur një gabim gjatë ruajtjes.</div>';
            }
        };
        xhr.send(formData);
      }
    </script>

</body>
</html>
