const {split, join} = require("lodash");

changeUserOnSelectChange = () => {
    const selectUser = document.getElementById('select-user');
    const changeUser = document.getElementById('change-user');

    const hrefArray = split(changeUser.href, '/');

    hrefArray[hrefArray.length-1] = selectUser.value;

    changeUser.href = join(hrefArray, '/')
};
