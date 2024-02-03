const getLocations = async (DBname) => {
  return new Promise((resolve, reject) => {
    let xhr = new XMLHttpRequest();

    const geocoder = new google.maps.Geocoder();

    xhr.open("POST", "./module/getData.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = () => {
      if (xhr.readyState === 4 && xhr.status === 200) {
        let response = JSON.parse(xhr.responseText);
        const data = response;
        const Locations = [];

        const processLocation = async (i) => {
          if (i < data.length) {
            try {
              const location = await geoCoding(geocoder, data[i].location);
              Locations.push(location);
              processLocation(i + 1);
            } catch (error) {
              reject(error);
            }
          } else {
            resolve(Locations);
          }
        };

        processLocation(0);
      }
    };

    xhr.send('DBname=' + DBname);
  });
}

/**
 * 
 * @param {String} address
 * @param {Object} geocoder
 * 
 * @returns
 */
export const geoCoding = (geocoder, address) => {
  return new Promise((resolve, reject) => {
    geocoder.geocode({ 'address': address }, (results, status) => {
      if (status == google.maps.GeocoderStatus.OK) {
        var location = results[0].geometry.location;
        const Location = {
          lat: location.lat(),
          lng: location.lng(),
        };
        resolve(Location); // データをセットして解決する
      } else {
        window.alert("登録した住所のジオコーディングに失敗しました。: " + status);

        resolve(null);
        reject(null);
      }
    });
  });
}

export const freeGeoCoding = async (address) => {
  return new Promise((resolve, reject) => {
    getLatLng(address, (latlng) => {
      console.log(latlng);
      resolve(latlng);
    }), (error) => {
      window.alert("ジオコーディングエラー: ", error);
      reject(error);
    }
  });
}

/**
 * 
 * @param {Array: [
 *  {Object: {
 *    lat: double,
 *    lng: double
 *  }}...
 * ]} Locations 
 */
const pushLocations = (Locations) => {
  // Ajaxリクエストを作成
  const xhr = new XMLHttpRequest();

  xhr.open("POST", "./module/pushLocation.php", true);
  xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

  // リクエストが完了したときの処理
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      // レスポンスを表示（PHPからの応答）
      console.log(xhr.responseText);
    }
  };

  console.log(Locations);
  xhr.send(JSON.stringify(Locations));
}