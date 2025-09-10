<!DOCTYPE html>
<html>
<head>
    <title>Protected Form</title>
    <script>
        // Disable copying content from the form fields
        document.addEventListener('copy', function (e) {
            e.preventDefault();
        });
    </script>
</head>
<body>
    <form>
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <button type="submit">Submit</button>
    </form>
</body>
echo 'this is the text'; 
</html>
