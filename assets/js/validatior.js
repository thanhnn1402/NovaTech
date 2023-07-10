function validator(options) {
    // Lấy element form cần validate
    var formElement = document.querySelector(options.form);

    function getParent(element, selector) {
        while (element.parentElement) {
            if (element.parentElement.matches(selector)) {
                return element.parentElement;
            } else {
                element = element.parentElement;
            }
        }
    }

    // Lưu lại các rules của input
    var selectorRules = {};

    // Hàm validate các input
    function validate(inputElement, rule) {
        var errorMessage;
        var errorElement = getParent(inputElement, options.formGroupSelector).querySelector(options.errorSelector);

        var rules = selectorRules[rule.selector];

        for (var i = 0; i < rules.length; i++) {
            switch (inputElement.type) {
                case 'checkbox':
                case 'radio':
                    errorMessage = rules[i](formElement.querySelector(rule.selector + ':checked'));
                    break;
                default:
                    errorMessage = rules[i](inputElement.value);
            }

            if (errorMessage) {
                break;
            }
        }

        if (errorMessage) {
            errorElement.innerText = errorMessage;
            getParent(inputElement, options.formGroupSelector).classList.add('invalid');
        } else {
            errorElement.innerText = '';
            getParent(inputElement, options.formGroupSelector).classList.remove('invalid');
        }

        return !errorMessage;
    }

    if (formElement) {

        formElement.onsubmit = (e) => {
            e.preventDefault();

            var formIsVaild = true;

            // Lặp qua từng rule và validate
            options.rules.forEach((rule) => {
                var inputElement = formElement.querySelector(rule.selector);
                var isValid = validate(inputElement, rule);

                if (!isValid) {
                    formIsVaild = false;
                }
            })

            if (formIsVaild) {
                // Trường hợp submit với javascript
                if (typeof options.onSubmit === 'function') {
                    var enabledInput = formElement.querySelectorAll('[name]:not([disabled])');
                    var formValues = Array.from(enabledInput).reduce(function(values, input) {
                        switch (input.type) {
                            case 'radio':
                                if (!input.matches(':checked')) {
                                    values[input.name] = '';
                                    return values;
                                }
                                values[input.name] = formElement.querySelector('input[name="' + input.name + '"]:checked').value;
                                break;
                            case 'checkbox':
                                if (!input.matches(':checked')) {
                                    values[input.name] = '';
                                    return values;
                                }
                                if (!Array.isArray(values[input.name])) {
                                    values[input.name] = [];
                                }
                                values[input.name].push(input.value);
                                break;
                            case 'file':
                                values[input.name] = input.files;
                                break;
                            default:
                                values[input.name] = input.value;
                        }

                        return values;
                    }, {})

                    options.onSubmit(formValues);
                } else {
                    formElement.submit();
                }
            }
        }

        options.rules.forEach((rule) => {

            if (Array.isArray(selectorRules[rule.selector])) {
                selectorRules[rule.selector].push(rule.test);
            } else {
                selectorRules[rule.selector] = [rule.test]
            }

            var inputElements = formElement.querySelectorAll(rule.selector);

            Array.from(inputElements).forEach((inputElement) => {
                // Xử lý khi blur khỏi input
                inputElement.addEventListener('blur', () => {
                    validate(inputElement, rule);

                })
                inputElement.addEventListener('change', () => {
                    validate(inputElement, rule);

                })

                // Xử lý xóa message lỗi khi người dùng bắt đầu nhập
                inputElement.oninput = () => {
                    var errorElement = getParent(inputElement, options.formGroupSelector).querySelector(options.errorSelector);
                    errorElement.innerText = '';
                    getParent(inputElement, options.formGroupSelector).classList.remove('invalid');
                }


            })
        })
    }
}

validator.isRequired = (selector, message) => {
    return {
        selector: selector,
        test: function(value) {
            return value ? undefined : message || 'Vui lòng nhập trường này';
        }
    }
}

validator.isEmail = (selector, message) => {
    return {
        selector: selector,
        test: function(value) {
            var regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            return regex.test(value) ? undefined : message || 'Vui lòng nhập đúng email'
        }
    }
}

validator.minLength = (selector, min, message) => {
    return {
        selector: selector,
        test: function(value) {
            return value.length >= min ? undefined : message || `Vui lòng nhập tối thiêu ${min} kí tự`
        }
    }
}

validator.isConfirm = (selector, getConfirm, message) => {
    return {
        selector: selector,
        test: function(value) {
            return value === getConfirm() ? undefined : message || `Giá trị nhập vào không đúng`
        }
    }
}