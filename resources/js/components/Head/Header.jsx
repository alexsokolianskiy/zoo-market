import React from 'react';
import ReactDOM from 'react-dom/client';

function Header() {
    return (
        <div className="container">
           Header
        </div>
    );
}

export default Header;

if (document.getElementById('header')) {
    const Index = ReactDOM.createRoot(document.getElementById("header"));

    Index.render(
        <React.StrictMode>
            <Header/>
        </React.StrictMode>
    )
}
