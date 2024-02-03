function initList() {
    var options = {
        valueNames: [ 'id', 'genre' ,'facility_name', 'location', 'tel', 'latitude', 'longitude' ]
    };
      
    var userList = new List('users', options);
}

initList();