// Initialize and add the map
let map, maker, image;
let AEDpubArr, AEDcnvArr, EMIArr;
import { freeGeoCoding } from "./js/DBconnect.js";

async function initMap() {
  let position = await getUserAddress();
  if (position) {
    if (!(window.confirm("開始位置を自分の住所にしますか？"))) position = { lat: 36.07637367211085, lng: 136.2128020251872 };
  } else {
    position = { lat: 36.07637367211085, lng: 136.2128020251872 };
  }

  const { Map } = await google.maps.importLibrary("maps");
  const { Marker } = await google.maps.importLibrary("marker");

  try {
    AEDpubArr = await getLocationsObject("getAED_public");
    AEDcnvArr = await getLocationsObject("getAED_conveniencestore");
    EMIArr = await getLocationsObject("getKyukyuiryoukikan");

    map = new Map(document.getElementById("map"), {
      zoom: 13,
      center: position,
    });

    image = {
      AED: {
        url: "./icon/AEDmini.png",
        size: new google.maps.Size(47, 46),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(0, 46),
      },
      ambulance: {
        url: "./icon/ambulance.png",
        size: new google.maps.Size(55, 55),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(0, 55),
      }
    };

    maker = new Marker({
      position: position,
      map,
      icon: image.ambulance,
    });

    // その他の地図関連の処理
  } catch (error) {
    console.error(error);
  }
}

const getUserAddress = async (geocoder) => {
  return new Promise((resolve, reject) => {
    const xhr = new XMLHttpRequest();

    xhr.open('GET', `./module/getUserAddress.php`, true);

    xhr.onreadystatechange = () => {
      if (xhr.readyState === 4 && xhr.status === 200) {
        let response = xhr.responseText;

        try {
          const address = JSON.stringify(response);

          if (address == 'not found') {
            console.log("住所情報が得られなかった");
            resolve(address);
          }
          console.log(address === "not found");
          console.log("得られた住所: ", address);

          const location = freeGeoCoding(address);
          console.log(location);

          resolve(location);
        } catch (error) {
          reject(error);
        }
      }
    };

    xhr.send();
  });
}

const getLocationsObject = async (fileName) => {
  return new Promise((resolve, reject) => {
    const xhr = new XMLHttpRequest();

    xhr.open('GET', `./module/${fileName}.php`, true);

    xhr.onreadystatechange = () => {
      if (xhr.readyState === 4 && xhr.status === 200) {
        let response = xhr.responseText;

        try {
          const data = JSON.parse(response);
          resolve(data);
        } catch (error) {
          reject('JSON パースエラー: ' + error);
        }
      }
    };

    xhr.send();
  });
}

initMap();

