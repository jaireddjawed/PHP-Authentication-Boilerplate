$.validator.addMethod('regex', function (value, element, param) {
  return this.optional(element) ||
    value.match(typeof param == 'string' ? new RegExp(param) : param);
}, 'Please enter a value in the correct format.');
