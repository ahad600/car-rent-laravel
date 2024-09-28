






async function readToken() {

    await axios.get(`/user/check`)
        .then(res => {
            console.log(res.data)
        })

        .catch(err => {
            if (err.status == 401) {
                window.location.replace("/login")
            }
        })
}


readToken()