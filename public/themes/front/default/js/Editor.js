var Editor = (function () {

    function Editor(element, options) {
        this.options = {
            editorClass: 'editable',
            editableElement: 'div',
            placeholder: null,
            inputName: null
        };

        this.element = element;
        this.oldElement = null;
        this.options = $.extend(this.options, options);
        this.editableElement = null;
        this.form = null;
        this.hiddenInput = null;

        this.initialise();

        if (this.options.placeholder) {
            this.setPlaceholder(this.options.placeholder);
        }
    };

    Editor.prototype.initialise = function() {
        this.oldElement = this.element.clone();

        this.editableElement = document.createElement(this.options.editableElement);
        this.editableElement = $(this.editableElement);

        this.editableElement.attr('contenteditable', 'true');
        this.editableElement.addClass(this.options.editorClass);

        this.element.replaceWith(this.editableElement);

        this.editableElement.focus();

        this.form = this.editableElement.closest('form');
        this.hiddenInput = $('<input>').attr({
            type: 'hidden',
            name: this.options.inputName,
            value: this.getValue()
        });

        this.hiddenInput.appendTo(this.form);

        this.registerListeners();
    };

    Editor.prototype.registerListeners = function () {
        this.editableElement.keydown($.proxy(function() {
            if (this.editableElement.html() == this.options.placeholder) {
                this.editableElement.html(null);
                this.editableElement.css('color', '#000');
            }
        }, this));

        this.form.submit($.proxy(function () {
            this.hiddenInput.attr('value', this.getValue());
        }, this));
    };

    Editor.prototype.setPlaceholder = function(placeholder) {
        this.editableElement.html(placeholder);
        this.editableElement.css('color', '#888');
    };

    Editor.prototype.getValue = function() {
        return this.editableElement.html();
    };

    Editor.prototype.setValue = function(value) {
        this.editableElement.html(value);
    };

    Editor.prototype.persistValue = function(value) {
        this.setValue(value);
        this.oldElement.html(value);
    };

    Editor.prototype.close = function () {
        this.editableElement.replaceWith(this.oldElement);
    };

    return Editor;

})();
