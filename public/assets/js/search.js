let searchbar = document.querySelector(".searchbar");
let imageWrapper = document.querySelector(".image-wrapper");

async function fetchAsync(url) {
    let response = await fetch(url);
    return await response.json();
}

let fetchData = () => {
    console.log(searchbar.value);
    let searched = searchbar.value;
    fetchAsync(`/images/search?title=${searched}`).then((data) => {
        imageWrapper.innerHTML = '';
        data.forEach((image) => {
            console.log(image)
            const contentWrapper = document.createElement("div");
            contentWrapper.classList.add("content-wrapper")
            const a = document.createElement("a");
            a.classList.add("imageLink")
            a.setAttribute("href", `/images/watermarks/watermarked${image.filename}`);
            const img = document.createElement("img");
            img.classList.add("image");
            img.setAttribute("src", `/images/miniatures/miniature${image.filename}`);
            img.classList.add("img");
            a.appendChild(img);
            contentWrapper.appendChild(a);
            imageWrapper.appendChild(contentWrapper);
        })
    });

}

searchbar.addEventListener("input", fetchData);
fetchData();