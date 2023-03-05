if (window === undefined) {
    throw Error("This script can only run in a browser!");
}

window.onload = () => {
    const title = document.querySelector("title");
    title.innerHTML = `${title.innerText} - Pápa kereső`;
};
