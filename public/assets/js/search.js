let searchbar = document.querySelector(".searchbar");
let imageWrapper = document.querySelector(".image-wrapper");

async function fetchAsync(url) {
    let response = await fetch(url);
    return await response.json();
}

let fetchData = () => {
    let searched = searchbar.value;
    fetchAsync(`/images/search?title=${searched}`).then((data) => {
        imageWrapper.innerHTML = '';
        data.forEach((image) => {
            const imageDiv = document.createElement("div");
            imageDiv.classList.add("image-div");
            const a = document.createElement("a");
            a.classList.add("imagelink");
            a.setAttribute("href", `/images/watermarks/watermarked${image.filename}`)
            const img = document.createElement("img");
            img.classList.add("image");
            img.setAttribute("src", `/images/miniatures/miniature${image.filename}`);
            img.setAttribute("alt", `${image.title}`);
            const imageText = document.createElement("div");
            imageText.classList.add("image-text");
            const span1 = document.createElement("span");
            span1.innerHTML = `Title: ${image.title}`
            const span2 = document.createElement("span");
            span2.innerHTML = `Author: ${image.author}`
            const span3 = document.createElement("span");
            if (image.privacy) {
                span3.innerHTML = `This image is private`;
            }
            const label = document.createElement("label");
            label.innerText = `Click to save image`;
            const input = document.createElement("input");
            input.setAttribute("type", `checkbox`);
            input.setAttribute("value", `${image.filename}`);
            input.setAttribute("name", `${image.filename}`);
            label.appendChild(input);
            imageText.appendChild(span1);
            imageText.appendChild(span2);
            imageText.appendChild(label);
            imageText.appendChild(span3);
            a.appendChild(img);
            imageDiv.appendChild(a);
            imageDiv.appendChild(imageText);
            imageWrapper.appendChild(imageDiv);
        })
    });

}

searchbar.addEventListener("input", fetchData);
fetchData();