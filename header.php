<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="assets/img/logo.ico">
    <title>Alley Games</title>
    <link rel="stylesheet" href="assets/css/custom.css">
    <meta name="Keywords" content="">
    <meta name="Description" content="">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4824731361768973" crossorigin="anonymous"></script>
    <meta name="google-adsense-account" content="ca-pub-4824731361768973">
    <script>
        let is_completeNext = false;
        let is_videoAd = false;
        let is_interstitial = false;
    </script>
    <script type="module">
        // Import the functions you need from the SDKs you need
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.4/firebase-app.js";
        import { getFirestore, getDocs, collection } from "https://www.gstatic.com/firebasejs/10.12.4/firebase-firestore.js";
        // TODO: Add SDKs for Firebase products that you want to use
        // https://firebase.google.com/docs/web/setup#available-libraries

        // Your web app's Firebase configuration
        // For Firebase JS SDK v7.20.0 and later, measurementId is optional
        const firebaseConfig = {
            apiKey: "AIzaSyD1zKVxsNfRqEnl5DCtLmyUiy7K3pgj_Rc",
            authDomain: "alley-b9d49.firebaseapp.com",
            projectId: "alley-b9d49",
            storageBucket: "alley-b9d49.appspot.com",
            messagingSenderId: "466077068329",
            appId: "1:466077068329:web:d2215cf58588f6fa594038",
            measurementId: "G-CLVTHKDXPW"
        };

        // Initialize Firebase
        const app = initializeApp(firebaseConfig);
        const db = getFirestore(app);

        const querySnapshot = await getDocs(collection(db, "alley"));
        querySnapshot.forEach((doc) => {
            const FireRes = doc.data();
            is_completeNext = FireRes.is_completeNext;
            is_videoAd = FireRes.is_videoAd;
            is_interstitial = FireRes.is_interstitial;
        });

    </script>
</head>
<body>
    <header>
        <div class="header-container">
            <a class="header-logo" href="index.php">
                <img src="assets/img/logo.png" alt="Alley">
                <span class="logo-text">Alley Games</span>
            </a>
            <div class="search-div">
                <img src="assets/img/search_icon.png" class="search-icon" alt="search-icon">
                <input type="text" class="search-box" name="search" id="search" placeholder="search..." autocomplete="off">
            </div>
            <div class="menu-div">
                <img src="assets/img/menu.png" class="menu-icon" id="toggle_menu" alt="menu-icon">
            </div>
        </div>
    </header>
    <div class="main-page">
        