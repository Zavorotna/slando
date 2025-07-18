document.addEventListener("DOMContentLoaded", function () {
    if (document.querySelector('.rate-stars')) {
        //reviews star rating

        function setRating(stars, rating) {
            stars.forEach((star, index) => {
                star.classList.toggle('active', index < rating);
            });
        }

        function setStarsReviews() {
            const rateBlocks = document.querySelectorAll('.rate-stars');

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

        }

        function getStars() {
            if (document.querySelector(".rating")) {
                const availableRating = document.querySelectorAll(".rating")

                availableRating.forEach(rat => {
                    const stars = rat.nextElementSibling.querySelectorAll('.star-review')

                    setRating(stars, rat.value)

                })
            }
        }

        setStarsReviews()

        function editReviews() {

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
        }
        editReviews()
        getStars()

        // let url = (location.href.split('/').includes('public')) ? location.href.slice(0, location.href.indexOf('public') + 6) : '';

        //ajax for delete review
        function deleteAjaxReview() {
            document.querySelectorAll('.delete_review').forEach(btn => {
                if (!btn.dataset.listenerAdded) {
                    console.log(btn.dataset);
                    btn.addEventListener('click', function (e) {
                        e.preventDefault();

                        const form = btn.closest('form');
                        if (!form) return;

                        fetch(form.action, {
                                method: 'DELETE',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                }
                            })
                            .then(res => {
                                if (res.ok) {
                                    const reviewBlock = form.closest('.review_block');
                                    if (reviewBlock) reviewBlock.remove();

                                    const noReviews = document.querySelector(".no-reviews");
                                    if (noReviews && document.querySelectorAll('.review_block').length === 0) {
                                        noReviews.style.display = "block";
                                    }
                                } else {
                                    console.error('Помилка видалення відгуку');
                                }
                            });
                    });

                    btn.dataset.listenerAdded = true;
                }
            });

        }

        deleteAjaxReview()

        //ajax for add review
        if (document.querySelector(".reviews_container")) {
            const form = document.querySelector(".reviews_container"),
                reviewsBlock = document.querySelector(".all_reviews_block")

            form.addEventListener("submit", function (e) {
                e.preventDefault()

                const formData = new FormData(form),
                    data = Object.fromEntries(formData.entries())

                fetch(form.action, {
                        method: "POST",
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(data)

                    })
                    .then(response => response.text())
                    .then(data => {
                        const newReview = document.createElement("div")
                        newReview.classList.add('review_block')
                        newReview.innerHTML = data

                        reviewsBlock.prepend(newReview)

                        const noReviews = document.querySelector(".no-reviews")
                        if (noReviews) noReviews.style.display = "none"

                        getStars()
                        deleteAjaxReview()
                        form.reset()
                    })
                    .catch(error => {
                        console.error("Помилка при створенні відгуку:", error);
                    });
            })

        }

        // ajax for update review
        document.querySelectorAll('.edit_form form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(form);
                const data = Object.fromEntries(formData.entries());
                const reviewId = form.action.match(/\/(\d+)$/)[1];
                console.log(data);
                fetch(form.action, {
                        method: 'PATCH',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(data)
                    })
                    .then(res => res.text())
                    .then(html => {
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = html.trim();

                        if (tempDiv) {
                            const oldReview = document.querySelector(`.review_block[data-id="${reviewId}"]`);
                            if (oldReview) {
                                oldReview.replaceWith(tempDiv);
                                getStars()
                                editReviews()
                                setStarsReviews()
                                getStars()
                                deleteAjaxReview()
                            }
                        }

                    })
                    .catch(err => console.error('Помилка оновлення відгуку:', err));
            });
        });

        //ajax for reviews pagination
        function reviewPaginationLinks() {
            const linksPag = document.querySelectorAll(".pagination a")

            linksPag.forEach(link => {
                link.addEventListener("click", function (e) {
                    e.preventDefault()

                    const url = e.currentTarget.href

                    fetch(url, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.text())
                        .then(html => {
                            document.querySelector('.all_reviews_block').innerHTML = html

                            window.history.pushState({
                                ajax: true
                            }, '', url)

                            reviewPaginationLinks()
                            editReviews()
                            setStarsReviews()
                            getStars()
                            deleteAjaxReview()
                        })
                })
            })
        }

        reviewPaginationLinks()
    }

    // ajax for catalogue pagination    
    if (document.querySelector(".catalogue_container")) {
        function bindPaginationLinks() {
            const linksPag = document.querySelectorAll(".pagination a")

            linksPag.forEach(link => {
                link.addEventListener("click", function (e) {
                    e.preventDefault()

                    const url = e.currentTarget.href

                    fetch(url, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.text())
                        .then(html => {
                            document.querySelector('.catalogue_container').innerHTML = html

                            window.history.pushState({
                                ajax: true
                            }, '', url)

                            bindPaginationLinks()
                        })
                })
            })
        }

        bindPaginationLinks()
    }
})
