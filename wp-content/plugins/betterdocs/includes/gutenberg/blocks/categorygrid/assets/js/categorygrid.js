window.addEventListener('load', function (event) {
    let masonryGrids = document.querySelectorAll(
        '.betterdocs-category-grid.masonry'
    );

    if (!masonryGrids) return;

    var mobileDevice = window.matchMedia('(max-width: 767px)');
    var tabDevice = window.matchMedia('(max-width: 1024px)');

    masonryGrids.forEach((masonryGrid) => {
        let columnPerGrid = mobileDevice.matches
            ? masonryGrid.getAttribute('data-mobile-column')
            : tabDevice.matches
            ? masonryGrid.getAttribute('data-tab-column')
            : masonryGrid.getAttribute('data-column');
        let masonryItems = masonryGrid.querySelectorAll(
            '.el-betterdocs-category-grid-post'
        );
        let column_space = mobileDevice.matches
            ? masonryGrid.getAttribute('data-mobile-colomn-space')
            : tabDevice.matches
            ? masonryGrid.getAttribute('data-tab-colomn-space')
            : masonryGrid.getAttribute('data-colomn-space');

        let total_margin = parseInt(columnPerGrid) * parseInt(column_space);

        if (masonryGrid) {
            masonryItems.forEach((item) => {
                item.style.width =
                    'calc((100% - ' +
                    total_margin +
                    'px) / ' +
                    parseInt(columnPerGrid) +
                    ')';
            });

            let msnry = new Masonry(masonryGrid, {
                itemSelector: '.el-betterdocs-category-grid-post',
                percentPosition: true,
                gutter: parseInt(column_space),
            });
        }
    });

    var buttons = document.querySelectorAll(
        '.elgb-betterdocs-grid-sub-cat-title'
    );

    buttons.forEach((button) => {
        button.addEventListener('click', () => {
            const wrapperInit = button.nextElementSibling;
            const displayValue = window
                .getComputedStyle(wrapperInit, null)
                .getPropertyValue('display');
            if (displayValue == 'none') {
                wrapperInit.style.display = 'block';
                button.querySelector('.arrow-down').style.display =
                    'inline-block';
                button.querySelector('.arrow-right').style.display = 'none';
            } else {
                wrapperInit.style.display = 'none';
                button.querySelector('.arrow-down').style.display = 'none';
                button.querySelector('.arrow-right').style.display =
                    'inline-block';
            }
        });
    });
});
