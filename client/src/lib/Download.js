
/*
DOWNLOAD DATA TO A CSV FILE - FUNCTION LIBRARY
*/

function getJsonHeader(arrData) {
  let header = '';
  header = Object.keys(arrData[0]).map((key) => {
    if (key === 'deleted_at') {
      return 'STATUS';
    }
    return `${(key).toUpperCase()},`;
  });
  return `${header}\r\n`;
}

function getJsonData(arrData) {
  let data = '';
  // for (let index = 0; index < arrData.length; index++) {
  Object.keys(arrData).forEach((index) => {
    let row = '';
    row = Object.keys(arrData[index]).map(key => `"${arrData[index][key]}",`);
    row.slice(0, data.length - 1);
    data += `${row}\r\n`;
  });
  return data;
}

function downloadFile(data, filename) {
  console.log('downloadFile funtion');
  // Initialize file format you want csv or xls
  const uri = `data:text/csv;charset=utf-8,${escape(data)}`;
  console.log('downloadFile funtion');
  // this trick will generate a temp <a /> tag
  const link = document.createElement('a');
  link.href = uri;
  console.log('downloadFile1 funtion');
  // set the visibility hidden so it will not effect on your web-layout
  link.style = 'visibility:hidden';
  console.log('downloadFile2 funtion');
  // this will remove the blank-spaces from the title and replace it with an underscore
  link.download = `${(filename).replace(/ /g, '_')}.csv`;
  // this part will append the anchor tag and remove it after automatic click
  console.log('downloadFile3 funtion');
  document.body.appendChild(link);
  console.log('downloadFile funtion');
  link.click();
  console.log('downloadFile4 funtion');
  document.body.removeChild(link);
}

export default function exportToFile(jsonData, filename, showHeader) {
  // If jsonData is not an object then JSON.parse will parse the JSON string in an Object
  const arrData = typeof jsonData !== 'object' ? JSON.parse(jsonData) : jsonData;
  // Initialize CSV String
  let data = '\n';
  if (showHeader) {
    data += getJsonHeader(arrData);
  }
  data += getJsonData(arrData);
  downloadFile(data, filename);
}
