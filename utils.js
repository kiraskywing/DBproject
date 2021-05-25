function isNonNegativeInteger(value) {
  const floatValue = parseFloat(value);
  return (
    (floatValue >= 0)
    && Number.isInteger(floatValue)
  );
}

function isPositive(value) {
  const numberValue = parseFloat(value);
  return (numberValue > 0 && Number.isInteger(numberValue));
}

function hasValue(value) {
  return Boolean(value);
}

function isCellPhoneNumber(value) {
  const nonNumberTester = /\D/;                    
  return !nonNumberTester.test(value) && (value.length === 10);
}

function isWhiteSpaceOnly(value = '') {
  const handledValue = value.trim();
  return handledValue.length === 0;
}
