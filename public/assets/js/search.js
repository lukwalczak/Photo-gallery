let searchbar = document.querySelector(".searchbar");
console.log(searchbar);

async function fetchAsync(url) {
    let response = await fetch(url);
    return await response.json();
}

searchbar.addEventListener("keyup", (e) => {
    let searched = searchbar.value;
    fetchAsync(`http://192.168.56.10:8080/images/search?title=${searched}`).then((data) => {
        data.forEach((image) => {
            console.log(image)
        })
    });
})