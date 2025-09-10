<!DOCTYPE html>
<html>
<head>
<title>Magnify Text on Hover</title>
<style>
.text {
  font-size: 16px;
}
.text:hover {
  font-size:40px;
}
</style>
</head>
<body>
<h1>Magnify Text on Hover</h1>
<p class="text">This is a text that will be magnified when you hover over it.</p>
<script>
$(document).ready(function() {
  $('.text').hover(function() {
    $(this).css('font-size', '24px');
  }, function() {
    $(this).css('font-size', '16px');
  });
});
</script>
</body>
</html>


