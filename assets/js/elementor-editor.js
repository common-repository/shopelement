elementor.hooks.addFilter("panel/elements/regionViews", function (panel) {

    let categoryCollection   = panel.categories.options.collection,
        foundCategory = null;

    // Search for the category with the name "shopelement_cat"
    categoryCollection.models.forEach(function (category) {
        if (category.get("name") === 'shopelement_cat') {
            foundCategory = category;
        }
    });

    if (foundCategory) {
        let items = foundCategory.get("items");

        let proItem = [{ name: 'shopelement-image-marker', title: 'Image Marker', icon: 'eicon-bullet-list shopelement_cat_pro_item', categories: ["shopelement_cat"], editable: false }, { name: 'shopelement-product-image-accordion', title: 'Product image accordion', icon: 'eicon-accordion shopelement_cat_pro_item', categories: ["shopelement_cat"], editable: false }];

        proItem.forEach(function (item) {
            items.push(item);
        });

        // Set the updated items back into the category
        foundCategory.set("items", items);
    }

    return panel;
});

parent.document.addEventListener("mousedown", function (e) {
    let allProElement = parent.document.querySelectorAll(".elementor-element--promotion");

    if (allProElement.length > 0) {
        allProElement.forEach(function (widget) {
            if (widget.contains(e.target)) {
                let elementPromotionDialog = parent.document.querySelector("#elementor-element--promotion__dialog");

                // If the icon has 'shopelement_cat_pro_item' class, handle Pro link logic
                if (widget.querySelector(".icon > i").classList.contains('shopelement_cat_pro_item')) {
                    // Hide the default Elementor Pro action button
                    elementPromotionDialog.querySelector("button.dialog-buttons-action").classList.add("hide-elementor-pro-btn-action");

                    // Check if the Pro link already exists, if not, create it
                    if (!elementPromotionDialog.querySelector(".dialog-buttons-wrapper a.shop-element-pro-link")) {
                        let proLink = document.createElement("a");
                        proLink.setAttribute("href", "https://storeplugin.net/plugins/shopelement/");
                        proLink.setAttribute("target", "_blank");
                        proLink.classList.add("shop-element-pro-link", "elementor-button", "go-pro", "dialog-button");
                        proLink.innerHTML = "Upgrade to Pro";

                        // Append the Pro link to the button wrapper
                        elementPromotionDialog.querySelector(".dialog-buttons-wrapper").appendChild(proLink);
                    } else {
                        // Ensure the Pro link is visible if it already exists
                        elementPromotionDialog.querySelector("a.shop-element-pro-link").classList.remove("hide-shop-element-pro-link");
                    }
                } else {
                    // Hide the Pro link if the icon does not have the 'shopelement_cat_pro_item' class
                    elementPromotionDialog.querySelector("a.shop-element-pro-link").classList.add("hide-shop-element-pro-link");
                }
            }
        });
    }
});
