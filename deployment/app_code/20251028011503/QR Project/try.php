<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Responsive Page</title>
<style>
/* CSS code for responsive page */
body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
}

.header {
  background-color: #333;
  color: #fff;
  padding: 20px;
  text-align: center;
}

.content {
  padding: 20px;
}

.footer {
  background-color: #333;
  color: #fff;
  padding: 10px;
  text-align: center;
}

/* Responsive styles */
@media screen and (max-width: 600px) {
  .content {
    padding: 10px;
  }
}
</style>
</head>
<body>

<div class="header">
  <h1>Responsive Page</h1>
</div>

<div class="content">
  <p>This is the content of the page. It will adjust based on the width of the screen.</p>
</div>

<div class="footer">
  <p>Footer content here</p>
</div>

</body>
</html>
