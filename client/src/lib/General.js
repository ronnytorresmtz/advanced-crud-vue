/*
GENERAL FUNCTION LIBRARY
*/
    /*
    * Create and return an Identical js object
    * received as parameter.
    */
    export default function createObj(input) {
      const obj = {};
      Object.keys(input).forEach((key) => {
        obj[key] = input[key];
      });
      return obj;
    }
    /*
    * Create an empty JS Object identical to the
    * received Object with not values.
    */
    export function resetObjVal(input) {
      const obj = {};
      Object.keys(input).forEach((key) => {
        obj[key] = '';
      });
      return obj;
    }
    /*
    * Store a Key Value in the Local Storage
    */
    export function storeInLocalStorage(key, value) {
      if (typeof (Storage) !== 'undefined') {
        localStorage.setItem(key, value);
      }
    }
     /*
    * Get the value of a Module/Key from the Local Storage
    */
    export function getValueFromLocalStorage(moduleName, key, defaultValue) {
      const value = localStorage.getItem(`${moduleName}/${key}`);
      return (value === null) ? defaultValue : value;
    }
     /*
    * Check if the email is a valid email
    */
    export function isValidEmail(email) {
      const emailReg = /^([\w-.]+@([\w-]+\.)+[\w-]{2,4})?$/;
      return emailReg.test(email);
    }
    /*
    * Compare two values receivend in the key object
    * and return 1 if the first object is greater
    * otherwise return -1.
    * This function is used as pararmeter in the
    * for Sort function.
    */
    // export function compareValues(key, order = 'asc') {
    //   return (a, b) => {
    //     const varA = (typeof a[key] === 'string') ? a[key].toUpperCase() : a[key];
    //     const varB = (typeof b[key] === 'string') ? b[key].toUpperCase() : b[key];
    //     let comparison = 0;
    //     if (varA > varB) {
    //       comparison = 1;
    //     } else if (varA < varB) {
    //       comparison = -1;
    //     }
    //     return (
    //       (order === 'desc') ?
    //       (comparison * -1) : comparison
    //     );
    //   };
    // }
