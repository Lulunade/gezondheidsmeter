var circle1 = document.getElementById("circle1");

switch (nummer) {
    case (nummer <= 25):
        circle1.style.fill = "red";
        break
    case (nummer <= 50):
        circle1.style.fill = "yellow";
        break
    case (nummer <= 75):
        circle1.style.fill = "lightgreen";
        break
    case (nummer <= 100):
        circle1.style.fill = "green";
        break
}