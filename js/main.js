document.addEventListener("DOMContentLoaded", () => {

    const currentPath = window.location.pathname.split("/").pop();
    const navLinks = document.querySelectorAll(".nav-links a");

    navLinks.forEach(link => {
        if (link.getAttribute("href") === currentPath || (currentPath === "" && link.getAttribute("href") === "index.php")) {
            link.classList.add("active");
        }
    });


    const cards = document.querySelectorAll(".card, .media-grid > div");
    cards.forEach((card, index) => {
        card.style.opacity = "0";
        card.style.transform = "translateY(15px)";
        card.style.transition = "all 0.3s ease-out";

        setTimeout(() => {
            card.style.opacity = "1";
            card.style.transform = "translateY(0)";
        }, 80 * index);
    });


    const searchInput = document.getElementById("searchMedia");
    if (searchInput) {
        searchInput.addEventListener("input", (e) => {
            const query = e.target.value.toLowerCase();
            cards.forEach(card => {
                const title = card.querySelector("h3")?.textContent.toLowerCase() || "";
                const desc = card.querySelector("p")?.textContent.toLowerCase() || "";
                if (title.includes(query) || desc.includes(query)) {
                    card.style.display = "flex";
                } else {
                    card.style.display = "none";
                }
            });
        });
    }
});