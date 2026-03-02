import React from 'react';
import './../Css/Menu.css'; // Opcional: para los estilos
import { Link } from 'react-router-dom';


const Navbar = () => {
  return (
    <nav className="navbar">
      <div className="navbar-logo">
        {/* Reemplaza 'logo.png' con la ruta de tu imagen */}
        <img src="/logo_club.png" alt="Statistical Solutions Logo" />
        <span>SSC - ESPOCH</span>
      </div>

      <ul className="navbar-links">
        <Link to="/">Inicio</Link>
        <li><a href="#proyectos">Proyectos</a></li>
        <Link to="/Actividades_desarrolladas">Actividades Desarrolladas</Link>
        
        <li><a href="#estadisticas">Actividades Planificadas</a></li>
        <Link to="/Contacto">Contacto</Link>
        
        
      </ul>
    </nav>
  );
};

export default Navbar;