if (document.querySelector('.rate-stars')) {
    //reviews star rating
    const rateBlocks = document.querySelectorAll('.rate-stars');

    function setRating(stars, rating) {
        stars.forEach((star, index) => {
            star.classList.toggle('active', index < rating);
        });
    }

    rateBlocks.forEach(block => {
        const stars = block.querySelectorAll('.star-review');
        const hiddenInput = block.closest('.star-review-block')?.querySelector('input[type="hidden"]');

        stars.forEach((star, index) => {
            star.addEventListener('click', function () {
                const rating = index + 1;

                setRating(stars, rating);
                if (hiddenInput) {
                    hiddenInput.value = rating;
                }
            });
        });
    });

    function getStars() {
        if (document.querySelector(".rating")) {
            const availableRating = document.querySelectorAll(".rating")

            availableRating.forEach(rat => {
                const stars = rat.nextElementSibling.querySelectorAll('.star-review')

                console.log(rat.value);
                setRating(stars, rat.value)

            })
        }
    }

    const editForm = document.querySelectorAll(".edit_form")

    editForm.forEach(item => {
        let editB = item.querySelector(".edit_button"),
            editCta = item.querySelector(".submit_edit")

        editB.addEventListener("click", function (e) {
            e.preventDefault()
            item.querySelector('form').classList.remove('d-none')
            getStars()
        })
        editCta.addEventListener("click", function () {
            item.querySelector('form').classList.add('d-none')
        })
    })



    getStars()
}
