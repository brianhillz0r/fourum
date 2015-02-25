var InlineEditor = (function() {

    function InlineEditor(postElement, options) {
        this.options = {
            inputName: null
        };

        this.options = $.extend(this.options, options);
        this.postElement = $(postElement);
        this.contentElement = $(this.postElement.find('.post-content'));
        this.postId = this.postElement.attr('id');
        this.editor = null;
        this.controls = null;
        this.oldControls = null;

        this.initialise();
    };

    InlineEditor.prototype.initialise = function () {
        var content = this.contentElement.html();

        this.editor = new Editor(this.contentElement, {
            inputName: this.options.inputName,
            editableElement: 'p'
        });

        this.editor.setValue(content);

        this.controls = $(this.postElement.find('.post-controls'));

        this.open();
    };

    InlineEditor.prototype.close = function () {
        this.closeControls();
        this.editor.close();

        registerDataListeners(this.postElement);
    };

    InlineEditor.prototype.closeControls = function () {
        this.controls.replaceWith(this.oldControls);
    };

    InlineEditor.prototype.open = function () {
        this.oldControls = this.controls.clone();

        this.controls.empty();

        this.openControls();
    };

    InlineEditor.prototype.openControls = function () {
        this.buildCloseControl();
        this.buildSaveControl();
    };

    InlineEditor.prototype.buildCloseControl = function () {
        var closeControl = $(document.createElement('a'));
        closeControl.addClass('btn btn-default');
        closeControl.html('Close');

        closeControl.click($.proxy(function () {
            this.close();
        }, this));

        this.controls.append(closeControl);
    };

    InlineEditor.prototype.buildSaveControl = function () {
        var saveControl = $(document.createElement('a'));
        saveControl.addClass('btn btn-primary');
        saveControl.html('Save');

        saveControl.click($.proxy(function () {
            this.save();
        }, this));

        this.controls.append(saveControl);
    };

    InlineEditor.prototype.save = function () {
        $.ajax('/post/edit', {
            type: 'POST',
            data: {
                postId: this.postId,
                content: this.editor.getValue()
            }
        }).done($.proxy(function(data) {
            this.populateSavedValue(data.content);
            this.close();
        }, this));
    };

    InlineEditor.prototype.populateSavedValue = function (value) {
        this.editor.persistValue(value);
    };

    return InlineEditor;

})();

var registerDataListeners = function(element) {
    if (element) {
        element.find('[data-inline-edit]').each(function (index, element) {
            element = $(element);

            element.click(function (click) {
                click.preventDefault();

                var postId = element.data('inline-edit');
                var postElement = $('#' + postId);

                var inlineEditor = new InlineEditor(postElement, {
                    inputName: 'test'
                })
            });
        });
    } else {
        $('[data-inline-edit]').each(function (index, element) {
            element = $(element);

            element.click(function (click) {
                click.preventDefault();

                var postId = element.data('inline-edit');
                var postElement = $('#' + postId);

                var inlineEditor = new InlineEditor(postElement, {
                    inputName: 'test'
                })
            });
        });
    }
};

(function() {
    registerDataListeners();
})();
