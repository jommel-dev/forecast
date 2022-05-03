let thenCallBack = (res) => {
  let response = {};
  if (res.status >= 200 && res.status <= 299) {
    response.data = res.data;
    response.code = 0;
  } else {
    response.data = res.data;
    response.code = 99;
  }

  return response;
};

let catchCallBack = (error) => {
  let response = {};
  if (typeof error.response !== "undefined") {
    response.data = error.response.data;
    response.code = error.response.status;
  } else {
    response.data = "System Server Error. Please contact Administrator";
    response.code = 999;
  }

  return response;
};

module.exports = {
  thenCallBack,
  catchCallBack,
};
