import React from 'react';
import ReactDOM from 'react-dom/client';

function LeftMenu() {
    return (
        <div className="container">
           Left menu
        </div>
    );
}

export default LeftMenu;

if (document.getElementById('left-menu')) {
    const Index = ReactDOM.createRoot(document.getElementById("left-menu"));

    Index.render(
        <React.StrictMode>
            <LeftMenu/>
        </React.StrictMode>
    )
}
