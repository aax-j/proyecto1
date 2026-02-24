
import './App.css';

import './index.css';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import Menu from './Js/menu.js'
import Footer from './Js/Footer.js'
import Inicio from './View/Inicio';
import Contacto from './View/Contacto';


function App() {
  return (
      <div className="App">
        <header className="App-header">
        <Router>
        <Menu /> {/* El Navbar se queda fijo en todas las páginas */}
      
        <Routes>
        <Route path="/" element={<Inicio />} />
        <Route path="/contacto" element={<Contacto />} />
        
        {/* Agrega aquí más rutas según necesites */}
        </Routes>
        <Footer /> {/* Se coloca aquí para que se vea siempre abajo */}
      </Router>
      </header>
    </div>
  );
}

export default App;
