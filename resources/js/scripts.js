document.addEventListener("DOMContentLoaded", function () {
    let icon = {
        success: '<span class="material-symbols-outlined"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="30" height="30" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><g fill="#4d83e6" data-name="Flat Color"><path d="M12 22.75a10.75 10.75 0 0 1 0-21.5 10.53 10.53 0 0 1 4.82 1.15.75.75 0 0 1-.68 1.34 9 9 0 0 0-4.14-1A9.25 9.25 0 1 0 21.25 12a2 2 0 0 0 0-.25.75.75 0 1 1 1.5-.14V12A10.76 10.76 0 0 1 12 22.75z" fill="#4d83e6" opacity="1" data-original="#4d83e6" class=""></path><path d="M11.82 15.41a.7.7 0 0 1-.52-.22l-4.83-4.74a.75.75 0 0 1 0-1.06.77.77 0 0 1 1.07 0l4.29 4.23 9.65-9.49a.77.77 0 0 1 1.07 0 .75.75 0 0 1 0 1.06l-10.18 10a.74.74 0 0 1-.55.22z" fill="#4d83e6" opacity="1" data-original="#4d83e6" class=""></path></g></g></svg></span>',
        info: '<span class="material-symbols-outlined"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="30" height="30" x="0" y="0" viewBox="0 0 330 330" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M165 0C74.019 0 0 74.02 0 165.001 0 255.982 74.019 330 165 330s165-74.018 165-164.999S255.981 0 165 0zm0 300c-74.44 0-135-60.56-135-134.999S90.56 30 165 30s135 60.562 135 135.001C300 239.44 239.439 300 165 300z" fill="#c80606" opacity="1" data-original="#c80606" class=""></path><path d="M164.998 70c-11.026 0-19.996 8.976-19.996 20.009 0 11.023 8.97 19.991 19.996 19.991 11.026 0 19.996-8.968 19.996-19.991 0-11.033-8.97-20.009-19.996-20.009zM165 140c-8.284 0-15 6.716-15 15v90c0 8.284 6.716 15 15 15 8.284 0 15-6.716 15-15v-90c0-8.284-6.716-15-15-15z" fill="#c80606" opacity="1" data-original="#c80606" class=""></path></g></svg></span>',
    };
    let toastTimeout
    const showToast = (
        message = "Sample Message",
        toastType = "info",
        duration = 5000) => {
        if (!Object.keys(icon).includes(toastType)) toastType = "info";
        if (toastTimeout) {
            clearTimeout(toastTimeout);
        }
        let box = document.createElement("div");
        box.classList.add(
            "toast", `toast-${toastType}`);
        box.innerHTML = ` <div class="toast-content-wrapper">
                        <div class="toast-icon">
                        ${icon[toastType]}
                        </div>
                        <div class="toast-message">${message}</div>
                        <div class="toast-progress"></div>
                        </div>`;
        duration = duration || 5000;
        // box.querySelector(".toast-progress").style.animationDuration =
        //     `${duration / 1000}s`;

        let toastAlready = document.body.querySelector(".toast");
        if (toastAlready) {
            toastAlready.remove();
        }

        document.body.appendChild(box)

        document.body.querySelector(".toast").style.zIndex = "10000"
        document.body.querySelector(".toast").style.opacity = "1"

        toastTimeout = setTimeout(function () {
            document.body.querySelector(".toast").style.zIndex = "-20"
            document.body.querySelector(".toast").style.opacity = "0"
        }, 5000)
    };
    if (document.querySelector('.rate-stars')) {
        //reviews star rating

        function setRating(stars, rating) {
            stars.forEach((star, index) => {
                star.classList.toggle('active', index < rating)
            })
        }

        function setStarsReviews() {
            const rateBlocks = document.querySelectorAll('.rate-stars')

            rateBlocks.forEach(block => {
                const stars = block.querySelectorAll('.star-review'),
                    hiddenInput = block.closest('.star-review-block')?.querySelector('input[type="hidden"]')

                stars.forEach((star, index) => {
                    star.addEventListener('click', function () {
                        const rating = index + 1

                        setRating(stars, rating)
                        if (hiddenInput) {
                            hiddenInput.value = rating
                        }
                    })
                })
            })

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
                if (editB) {
                    editB.addEventListener("click", function (e) {
                        e.preventDefault()
                        item.querySelector('form').classList.remove('d-none')
                        getStars()
                    })
                }
                editCta.addEventListener("click", function () {
                    item.querySelector('form').classList.add('d-none')
                })
            })
        }
        editReviews()
        getStars()

        // let url = (location.href.split('/').includes('public')) ? location.href.slice(0, location.href.indexOf('public') + 6) : ''

        //ajax for delete review
        function deleteAjaxReview() {
            document.querySelectorAll('.delete_review').forEach(btn => {
                if (!btn.dataset.listenerAdded) {
                    console.log(btn.dataset)
                    btn.addEventListener('click', function (e) {
                        e.preventDefault()

                        const form = btn.closest('form')
                        if (!form) return

                        fetch(form.action, {
                                method: 'DELETE',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                }
                            })
                            .then(res => {
                                if (res.ok) {
                                    const reviewBlock = form.closest('.review_block')
                                    if (reviewBlock) reviewBlock.remove()

                                    const noReviews = document.querySelector(".no-reviews")
                                    if (noReviews && document.querySelectorAll('.review_block').length === 0) {
                                        noReviews.style.display = "block"
                                    }
                                    showToast('Відгук видалено успішно', 'success')
                                } else {
                                    showToast('Помилка видалення відгуку', '')
                                }
                            })
                    })

                    btn.dataset.listenerAdded = true
                }
            })

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
                        editReviews()
                        form.reset()
                        showToast('Відгук створено успішно', 'success')
                    })
                    .catch(error => {
                        showToast('Помилка при створенні відгуку:', '')
                    })
            })

        }

        // ajax for update review
        document.querySelectorAll('.edit_form form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault()

                const formData = new FormData(form),
                    data = Object.fromEntries(formData.entries()),
                    reviewId = form.action.match(/\/(\d+)$/)[1]

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
                        const tempDiv = document.createElement('div')
                        tempDiv.innerHTML = html.trim()

                        if (tempDiv) {
                            const oldReview = document.querySelector(`.review_block[data-id="${reviewId}"]`)
                            if (oldReview) {
                                oldReview.replaceWith(tempDiv)
                                getStars()
                                editReviews()
                                setStarsReviews()
                                getStars()
                                deleteAjaxReview()
                            }
                        }
                        showToast('Відгук оновлено успішно', 'success')

                    })
                    .catch(error => {
                        showToast('Помилка оновлення відгуку:', '')
                    })
            })
        })

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

    // ajax for catalogue pagination and filters
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
                            addToCart()

                        })
                })
            })
        }

        bindPaginationLinks();

        if (document.querySelector(".slider")) {
            const slider = document.querySelector('.slider'),
                minHandle = document.querySelector('#min-handle'),
                maxHandle = document.querySelector('#max-handle'),
                range = document.querySelector('#range'),
                minPriceInput = document.querySelector('#min-price'),
                maxPriceInput = document.querySelector('#max-price'),
                sliderWidth = slider.offsetWidth,
                handleWidth = minHandle.offsetWidth


            function updateRange() {
                const minValueSpan = document.querySelector('#min-value'),
                    maxValueSpan = document.querySelector('#max-value')

                let minPrice = parseFloat(minValueSpan.dataset.price),
                    maxPrice = parseFloat(maxValueSpan.dataset.price)
                const minPos = minHandle.offsetLeft,
                    maxPos = maxHandle.offsetLeft

                range.style.left = minPos + 'px'
                range.style.width = (maxPos - minPos) + 'px'

                const scale = (maxPrice - minPrice) / (sliderWidth - handleWidth),
                    minValue = Math.round(minPrice + minPos * scale),
                    maxValue = Math.round(minPrice + maxPos * scale)

                minPriceInput.value = minValue
                maxPriceInput.value = maxValue
                minValueSpan.textContent = minValue
                maxValueSpan.textContent = maxValue
            }

            function handleDrag(e, handle) {
                e.preventDefault()
                const startX = e.clientX || e.touches[0].clientX,
                    startLeft = handle.offsetLeft

                const onMove = (moveEvent) => {
                    const moveX = moveEvent.clientX || moveEvent.touches[0].clientX
                    let newLeft = moveX - startX + startLeft

                    if (handle === minHandle) {
                        newLeft = Math.max(0, Math.min(newLeft, maxHandle.offsetLeft - handleWidth))
                    } else {
                        newLeft = Math.max(minHandle.offsetLeft + handleWidth, Math.min(newLeft, sliderWidth - handleWidth))
                    }

                    handle.style.left = newLeft + 'px'
                    updateRange()
                }

                const onEnd = () => {
                    document.removeEventListener('mousemove', onMove)
                    document.removeEventListener('mouseup', onEnd)
                    document.removeEventListener('touchmove', onMove)
                    document.removeEventListener('touchend', onEnd)

                    fetchCatalogue()
                }

                document.addEventListener('mousemove', onMove)
                document.addEventListener('mouseup', onEnd)
                document.addEventListener('touchmove', onMove)
                document.addEventListener('touchend', onEnd)
            }

            minHandle.addEventListener('mousedown', (e) => handleDrag(e, minHandle))
            maxHandle.addEventListener('mousedown', (e) => handleDrag(e, maxHandle))
            minHandle.addEventListener('touchstart', (e) => handleDrag(e, minHandle))
            maxHandle.addEventListener('touchstart', (e) => handleDrag(e, maxHandle))

            updateRange()

            const filterForm = document.querySelector('.filter'),
                catalogueContainer = document.querySelector('.catalogue_container'),
                searchInput = document.getElementById("search-input"),
                sortSelect = document.getElementById("sort-select")

            let timeout;
            if (!filterForm || !catalogueContainer) return

            function fetchCatalogue(url = window.location.href, skipPush = false) {
                const formData = new FormData(filterForm),
                    params = new URLSearchParams(formData).toString(),
                    finalUrl = `${url.split('?')[0]}?${params}`;

                fetch(finalUrl, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        catalogueContainer.innerHTML = html;

                        if (!skipPush) {
                            window.history.pushState({}, '', finalUrl);
                        }

                        bindPaginationLinks();
                        addToCart()
                    });
            }


            filterForm.addEventListener('change', () => {
                fetchCatalogue()
            })

            filterForm.addEventListener('submit', (e) => {
                e.preventDefault()
                fetchCatalogue()
            })

            const resetButton = filterForm.querySelector('button[type="reset"]')

            if (resetButton) {
                resetButton.addEventListener('click', (e) => {
                    setTimeout(() => {
                        const baseUrl = window.location.origin + window.location.pathname;
                        history.replaceState(null, '', baseUrl);

                        resetRange();

                        searchInput.value = '';
                        sortSelect.selectedIndex = 0;

                        fetchCatalogue();
                    }, 50);
                })
            }

            function restoreFilterStateFromUrl() {
                const params = new URLSearchParams(window.location.search),
                    form = document.querySelector(".filter")

                // Пошук
                if (searchInput) {
                    searchInput.value = params.get('search') || '';
                }

                // Сортування
                if (sortSelect) {
                    const sortValue = params.get('sort');
                    if (sortValue) {
                        sortSelect.value = sortValue;
                    } else {
                        sortSelect.selectedIndex = 0;
                    }
                }

                form.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                    const name = checkbox.name,
                        value = checkbox.value,
                        selected = params.getAll(name);
                    checkbox.checked = selected.includes(value);
                });


                // Ціни
                const minParam = parseInt(params.get('min_price'));
                const maxParam = parseInt(params.get('max_price'));
                if (!isNaN(minParam) && !isNaN(maxParam)) {
                    const sliderWidth = slider.offsetWidth - handleWidth;
                    const minSpan = document.querySelector('#min-value');
                    const maxSpan = document.querySelector('#max-value');
                    const minPrice = parseFloat(minSpan.dataset.price);
                    const maxPrice = parseFloat(maxSpan.dataset.price);
                    const scale = (maxPrice - minPrice) / sliderWidth;

                    const minLeft = (minParam - minPrice) / scale;
                    const maxLeft = (maxParam - minPrice) / scale;

                    minHandle.style.left = `${minLeft}px`;
                    maxHandle.style.left = `${maxLeft}px`;
                    updateRange();
                }
            }


            window.addEventListener('popstate', function (e) {
                restoreFilterStateFromUrl()
                fetchCatalogue(window.location.href, true);
            });


            // serch
            searchInput.addEventListener("input", () => {
                clearTimeout(timeout);
                timeout = setTimeout(() => fetchCatalogue(), 300);
            })

            sortSelect.addEventListener("change", () => fetchCatalogue());

            function resetRange() {
                minHandle.style.left = '0px';
                maxHandle.style.left = (slider.offsetWidth - handleWidth) + 'px';
                updateRange();
            }
        }

    }

    //перемикачка зображень відповідно до кольору
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

    //cart ajax

    //delete cart ajax
    if (document.querySelector(".basket_container")) {
        let basketContainer,
            forms

        function listener() {
            basketContainer = document.querySelector(".basket_container"),
                forms = basketContainer.querySelectorAll(".delete_btn")
            forms.forEach(form => {
                form.addEventListener("submit", function (e) {
                    e.preventDefault()
                    fetch(form.action, {
                            method: 'DELETE',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(res => res.text())
                        .then(html => {
                            basketContainer.innerHTML = html
                            listener()
                            showToast('Товар успішно видалено', 'success')
                        })
                })
            })
        }
        listener()
        //clear cart
        const clearForm = document.querySelector(".clear_cart")
        clearForm.addEventListener("submit", function (e) {
            // basketContainer = document.querySelector(".basket_container")
            e.preventDefault()
            fetch(clearForm.action, {
                    method: 'DELETE',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(res => res.text())
                .then(html => {
                    basketContainer.innerHTML = html
                    showToast('Кошик очищено', 'success')
                })
        })

    }

    //add to cart ajax
    function addToCart() {
        document.querySelectorAll(".add_to_cart").forEach(form => {
            form.addEventListener("submit", function (e) {
                e.preventDefault();
                const formData = new FormData(form),
                    sizeSelect = form.querySelector('select[name="sizes"]')

                if (!form.querySelector('input[name="color"]:checked')) {
                    showToast('Оберіть колір', '')
                    return
                }
                if (sizeSelect && !sizeSelect.value) {
                    showToast('Оберіть розмір', '')
                    return
                }
                fetch(form.action, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": form.querySelector('input[name="_token"]').value
                        },
                        body: formData
                    })
                    .then(res => {
                        res.text()
                        showToast('Товар додано у кошик', 'success')
                    })
            })
        })
    }
    addToCart()

    //update cart ajax

    if (document.querySelector('.cart_block')) {
        function attachCartEvents() {
            document.querySelectorAll('.quantity_form').forEach(form => {

                // кнопки + / -
                form.addEventListener('submit', e => {
                    e.preventDefault();
                    const btnValue = e.submitter.value;
                    sendUpdate(form, btnValue);
                });

                // input
                const input = form.querySelector('input[name="quantity"]');
                let timeout;
                input.addEventListener('input', () => {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => {
                        sendUpdate(form, 'set', input.value);
                    }, 300)
                });
            });
        }

        function sendUpdate(form, actionBtn, quantity = null) {
            const data = {
                id: form.querySelector('input[name="id"]').value,
                action_btn: actionBtn,
                quantity: quantity ?? form.querySelector('input[name="quantity"]').value
            };

            fetch(form.getAttribute('action'), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify(data)
                })
                .then(res => res.text())
                .then(html => {
                    document.querySelector('.basket_container').innerHTML = html;
                    attachCartEvents()
                    document.querySelector(".count_items").innerText = document.querySelector(".count").textContent
                })
                .catch(console.error);
        }
        attachCartEvents();
    }
})
