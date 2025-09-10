<!DOCTYPE html>
<html>
<head>
<style>
.button-rounded {
  border-radius: 15px;
  padding: 10px 20px;
  background-color: #3498db;
  color: white;
  border: none;
  cursor: pointer;
}
</style>
</head>
<body>

<form action="submit.php" method="post">
  <input type="text" name="input_field" placeholder="Enter something...">
  <button class="button-rounded" type="submit">Submit</button>
</form>

</body>
</html>

<!DOCTYPE html>
<html>
<head>
<style>
.button-circle {
  border-radius: 50%;

  padding: 15px 20px;
  background-color: #e74c3c;
  color: white;
  border: none;
  cursor: pointer;
}
</style>
</head>
<body>

<form action="submit.php" method="post">
  <input type="text" name="input_field" placeholder="Enter something...">
  <button class="button-circle" type="submit">Submit</button>
</form>

</body>
</html>
<!DOCTYPE html>
<html>
<head>
<style>
.button-pill {
  border-radius: 30px;
  padding: 10px 30px;
  background-color: #27ae60;
  color: white;
  border: none;
  cursor: pointer;
}
</style>
</head>
<body>

<form action="submit.php" method="post">
  <input type="text" name="input_field" placeholder="Enter something...">
  <button class="button-pill" type="submit">Submit</button>
</form>

</body>
</html>
<!DOCTYPE html>
<html>
<head>
<style>
.button-diagonal {
  border: none;
  position: relative;
  padding: 10px 40px;
  background-color: #f39c12;
  color: white;
  cursor: pointer;
}

.button-diagonal::before {
  content: '';
  position: absolute;
  top: 0;
  right: 0;
  border-top: 40px solid transparent;
  border-left: 40px solid #e74c3c;
}
</style>
</head>
<body>

<form action="submit.php" method="post">
  <input type="text" name="input_field" placeholder="Enter something...">
  <button class="button-diagonal" type="submit">Submit</button>
</form>

</body>
</html>
<!DOCTYPE html>
<html>
<head>
<style>
.button-hexagon {
  width: 100px;
  height: 58px;
  background-color: #9b59b6;
  color: white;
  border: none;
  clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
  cursor: pointer;
}
</style>
</head>
<body>

<form action="submit.php" method="post">
  <input type="text" name="input_field" placeholder="Enter something...">
  <button class="button-hexagon" type="submit">Submit</button>
</form>

</body>
</html>
<!DOCTYPE html>
<html>
<head>
<style>
.button-push {
  padding: 10px 20px;
  background-color: #3498db;
  color: white;
  border: 1px solid #2980b9;
  border-radius: 5px;
  box-shadow: 0px 3px 0px #2980b9;
  cursor: pointer;
  transition: background-color 0.3s, box-shadow 0.3s;
}

.button-push:hover {
  background-color: #2980b9;
  box-shadow: 0px 5px 0px #2980b9;
}
</style>
</head>
<body>

<form action="submit.php" method="post">
  <input type="text" name="input_field" placeholder="Enter something...">
  <button class="button-push" type="submit">Submit</button>
</form>

</body>
</html>


<style>
  .menu-button {
    background-color: #000000;
    color: #ffffff;
    padding: 10px;
    border-radius: 5px;
    cursor: pointer;

    &:hover {
      background-color: #ffffff;
      color: #000000;
    }
  }
</style>

<button class="menu-button">My Button</button>
