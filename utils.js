function isPositiveInteger(value) {
  const floatValue = parseFloat(value);
  return (
    (floatValue >= 0)
    && Number.isInteger(floatValue)
  );
}

function isPositive(value) {
  const numberValue = parseFloat(value);
  return (numberValue >= 0);
}

function hasValue(value) {
  return Boolean(value);
}

function isCellPhoneNumber(value) {
  const nonNumberTester = /\D/;                    
  return !nonNumberTester.test(value) && (value.length === 10);
}