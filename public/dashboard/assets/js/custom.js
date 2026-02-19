// Mobile menu toggle functionality
$('.button-mob-menu').on('click', function () {
    $('body').toggleClass('show-mob-menu');
});

$(window).on('resize', function() {
    if (window.matchMedia("(min-width: 1200px)").matches) {
        $('html').attr('data-menu-size', 'default');
        $('html').removeClass('sidebar-enable');
    }
}).trigger('resize');

$(window).on('resize', function() {
    if (window.matchMedia("(max-width: 1199.98px)").matches) {
        $('html').attr('data-menu-size', 'hidden');
    }
}).trigger('resize');
    
// Dropzone
var dropzonePreviewNode = document.querySelector("#dropzone-preview-list");
dropzonePreviewNode.id = "";

if (dropzonePreviewNode) {
    var previewTemplate = dropzonePreviewNode.parentNode.innerHTML;
    dropzonePreviewNode.parentNode.removeChild(dropzonePreviewNode);

    var dropzone = new Dropzone(".dropzone", {
        url: "https://httpbin.org/post",
        method: "post",
        previewTemplate: previewTemplate,
        previewsContainer: "#dropzone-preview",
        acceptedFiles: ".xlsx",
        dictInvalidFileType: "Only Excel (.xlsx) files are allowed.",
        init: function () {
            this.on("error", function (file, message) {
                console.error(message);
            });
        },
    });
}

// Add new product row
$(document).ready(function () {
    $(document).on('click', '.add-new', function () {
        let modal = $(this).closest('.modal');
        let wrapper = modal.find('.product-wrapper');

        let newRow = `
        <div class="product-row bg-light rounded p-2 grid grid-cols-12 gap-2 align-items-end mb-1">
            <div class="g-col-5 space-y-1">
                <label class="form-label">Product Name / SKU</label>
                <input type="text" class="form-control" placeholder="e.g., iPhone Case">
            </div>

            <div class="g-col-2 space-y-1">
                <label class="form-label">Qty</label>
                <input type="number" class="form-control" value="1" min="1">
            </div>

            <div class="g-col-4 space-y-1">
                <label class="form-label">Condition</label>
                <select class="form-select">
                    <option>New</option>
                    <option>Used</option>
                    <option>Return</option>
                    <option>Return Review</option>
                </select>
            </div>

            <div class="g-col-1 d-flex justify-content-end">
                <button class="btn btn-sm btn-light remove-row">
                    <i class="ri-delete-bin-line fs-18"></i>
                </button>
            </div>
        </div>`;

        wrapper.append(newRow);
        toggleRemoveButtons(modal);
    });

    // Remove product row (scoped)
    $(document).on('click', '.remove-row', function () {
        let modal = $(this).closest('.modal');
        $(this).closest('.product-row').remove();
        toggleRemoveButtons(modal);
    });

    // Enable / disable delete button per modal
    function toggleRemoveButtons(modal) {
        let rows = modal.find('.product-row');
        let buttons = modal.find('.remove-row');

        if (rows.length === 1) {
            buttons.prop('disabled', true);
        } else {
            buttons.prop('disabled', false);
        }
    }

    // When modal opens, reset delete button state
    $('.modal').on('shown.bs.modal', function () {
        toggleRemoveButtons($(this));
    });

});