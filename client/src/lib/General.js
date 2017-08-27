
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
    * Compare two values receivend in the key object
    * and return 1 if the first object is greater
    * otherwise return -1.
    * This function is used as pararmeter in the
    * for Sort function.
    */
    export function compareValues(key, order = 'asc') {
      return (a, b) => {
        const varA = (typeof a[key] === 'string') ? a[key].toUpperCase() : a[key];
        const varB = (typeof b[key] === 'string') ? b[key].toUpperCase() : b[key];
        let comparison = 0;
        if (varA > varB) {
          comparison = 1;
        } else if (varA < varB) {
          comparison = -1;
        }
        return (
          (order === 'desc') ?
          (comparison * -1) : comparison
        );
      };
    }
