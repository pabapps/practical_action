var initSelect = function(elem, placeholder, url){
  $(elem).select2({
    placeholder: 'enter ' + placeholder,
    ajax: {
      dataType: 'json',
      url: url,
      delay: 250,
      data: function(params) {
        return {
          term: params.term
        }
      },
      processResults: function (data, params) {
        params.page = params.page || 1;
        return {
          results: data
        };
      },
    }
  });
}

//these two consecutive functions are there to check is the input is a numeber or not
function isInt(n) {
  return n % 1 === 0;
}

function isFloat(x) { return !!(x % 1); }    

//checking if the string is empty or not
function isBlank(str) {
  return (!str || /^\s*$/.test(str));
}

function calcDaysBetween(startDate, endDate) {
  return (endDate - startDate) / (1000 * 60 * 60 * 24);
}




