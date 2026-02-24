import React from 'react';
import { Link } from 'react-router-dom';
import './../Css/Footer.css';

const Footer = () => {
  const currentYear = new Date().getFullYear();

  return (
    <footer className="footer">
      <div className="footer-container">
        {/* Columna 1: Info del Club */}
        <div className="footer-section">
          <h4 className="footer-title">SSC - ESPOCH</h4>
          <p className="footer-description">
            Club de Soluciones Estadísticas de la Escuela Superior Politécnica de Chimborazo. 
            Transformando datos en conocimiento.
          </p>
        </div>

        {/* Columna 2: Enlaces Rápidos */}
        <div className="footer-section">
          <h4 className="footer-title">Navegación</h4>

          <ul className="footer-links">
            <li><Link to="/">Inicio</Link></li>
            <li><Link to="/proyectos">Proyectos</Link></li>
            <li><Link to="/actividades desa">Actividades Desarrolladas</Link></li>
            <li><Link to="/actividades plan">Actividades Planificadas</Link></li>
            <li><Link to="/contacto">Contacto</Link></li>
          </ul>
        </div>

        {/* Columna 3: Contacto/Redes */}
        <div className="footer-section">
          <h4 className="footer-title">Contacto</h4>
          <p>📍 Riobamba, Ecuador</p>
          <div className="footer-socials">
            {/* Puedes agregar iconos aquí después */}
            <span>📸 Instagram</span>
          </div>
        </div>
      </div>

      <div className="footer-bottom">
        <p>&copy; {currentYear} Statistical Solutions Club. Todos los derechos reservados.</p>
        <p className="espoch-tag">Orgullosamente ESPOCH</p>
      </div>
    </footer>
  );
};

export default Footer;