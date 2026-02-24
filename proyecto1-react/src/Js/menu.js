import React from 'react';
import './../Css/Menu.css'; // Opcional: para los estilos


const Navbar = () => {
  return (
    <nav className="navbar">
      <div className="navbar-logo">
        {/* Reemplaza 'logo.png' con la ruta de tu imagen */}
        <img src="/path-to-your-logo.png" alt="Statistical Solutions Logo" />
        <span>SSC - ESPOCH</span>
      </div>

      <ul className="navbar-links">
        <li><a href="#inicio">Inicio</a></li>
        <li><a href="#proyectos">Proyectos</a></li>
        <li><a href="#estadisticas">Actividades Desarrolladas</a></li>
        <li><a href="#estadisticas">Actividades Planificadas</a></li>
        <li><a href="#contacto">Contacto</a></li>
        
      </ul>
    </nav>
  );
};

export default Navbar;