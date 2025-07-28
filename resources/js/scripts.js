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
    // if (document.querySelector(".catalogue_container")) {
    //     function bindPaginationLinks() {
    //         const linksPag = document.querySelectorAll(".pagination a")

    //         linksPag.forEach(link => {
    //             link.addEventListener("click", function (e) {
    //                 e.preventDefault()

    //                 const url = e.currentTarget.href

    //                 fetch(url, {
    //                         headers: {
    //                             'X-Requested-With': 'XMLHttpRequest'
    //                         }
    //                     })
    //                     .then(response => response.text())
    //                     .then(html => {
    //                         document.querySelector('.catalogue_container').innerHTML = html

    //                         window.history.pushState({
    //                             ajax: true
    //                         }, '', url)

    //                         bindPaginationLinks()
    //                     })
    //             })
    //         })
    //     }

    //     bindPaginationLinks()
    // }

    document.querySelectorAll('input[type="radio"][name="color"]').forEach(input => {
        input.addEventListener('change', function () {
            const card = input.closest('.product-card')
            if (!card) return

            const image = card.querySelector('.product-main-image'),
                url = input.dataset.imageUrls

            if (url && image) {
                image.src = url
            }
        })
    })

    const filterForm = document.querySelector('.filter'),
        catalogueContainer = document.querySelector('.catalogue_container')

    if (!filterForm || !catalogueContainer) return;

    function fetchCatalogue(url = window.location.href) {
        const formData = new FormData(filterForm),
            params = new URLSearchParams(formData).toString(),
            finalUrl = `${url.split('?')[0]}?${params}`

        fetch(finalUrl, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            catalogueContainer.innerHTML = html;
            window.history.pushState({}, '', finalUrl);
            bindPaginationLinks()
        })
        .catch(err => console.error('AJAX помилка:', err));
    }

    filterForm.addEventListener('change', () => {
        fetchCatalogue();
    });

    filterForm.addEventListener('submit', (e) => {
        e.preventDefault();
        fetchCatalogue();
    });

    filterForm.addEventListener('reset', () => {
        setTimeout(() => fetchCatalogue(), 100);
    });

    function bindPaginationLinks() {
        const links = catalogueContainer.querySelectorAll('.pagination a');

        links.forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                fetchCatalogue(link.href);
            });
        });
    }

    bindPaginationLinks();

    if (document.querySelector(".slider")) {
        const slider = document.querySelector('.slider'),
            minHandle = document.querySelector('#min-handle'),
            maxHandle = document.querySelector('#max-handle'),
            range = document.querySelector('#range'),
            minPriceInput = document.querySelector('#min-price'),
            maxPriceInput = document.querySelector('#max-price'),
            minValueSpan = document.querySelector('#min-value'),
            maxValueSpan = document.querySelector('#max-value'),
            sliderWidth = slider.offsetWidth,
            handleWidth = minHandle.offsetWidth;

        let minPrice = parseFloat(minValueSpan.dataset.price),
            maxPrice = parseFloat(maxValueSpan.dataset.price);

        function updateRange() {
            const minPos = minHandle.offsetLeft;
            const maxPos = maxHandle.offsetLeft;

            range.style.left = minPos + 'px';
            range.style.width = (maxPos - minPos) + 'px';

            const scale = (maxPrice - minPrice) / (sliderWidth - handleWidth);
            const minValue = Math.round(minPrice + minPos * scale);
            const maxValue = Math.round(minPrice + maxPos * scale);

            minPriceInput.value = minValue;
            maxPriceInput.value = maxValue;
            minValueSpan.textContent = minValue;
            maxValueSpan.textContent = maxValue;
        }

        function handleDrag(e, handle) {
            e.preventDefault();
            const startX = e.clientX || e.touches[0].clientX;
            const startLeft = handle.offsetLeft;

            const onMove = (moveEvent) => {
                const moveX = moveEvent.clientX || moveEvent.touches[0].clientX;
                let newLeft = moveX - startX + startLeft;

                if (handle === minHandle) {
                    newLeft = Math.max(0, Math.min(newLeft, maxHandle.offsetLeft - handleWidth));
                } else {
                    newLeft = Math.max(minHandle.offsetLeft + handleWidth, Math.min(newLeft, sliderWidth - handleWidth));
                }

                handle.style.left = newLeft + 'px';
                updateRange();
            };

            const onEnd = () => {
                document.removeEventListener('mousemove', onMove);
                document.removeEventListener('mouseup', onEnd);
                document.removeEventListener('touchmove', onMove);
                document.removeEventListener('touchend', onEnd);

                fetchCatalogue(); // Оновити товари після переміщення
            };

            document.addEventListener('mousemove', onMove);
            document.addEventListener('mouseup', onEnd);
            document.addEventListener('touchmove', onMove);
            document.addEventListener('touchend', onEnd);
        }

        minHandle.addEventListener('mousedown', (e) => handleDrag(e, minHandle));
        maxHandle.addEventListener('mousedown', (e) => handleDrag(e, maxHandle));
        minHandle.addEventListener('touchstart', (e) => handleDrag(e, minHandle));
        maxHandle.addEventListener('touchstart', (e) => handleDrag(e, maxHandle));

        updateRange(); // стартова ініціалізація
    }

});
