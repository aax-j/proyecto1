import React from 'react';
import './../Css/Inicio.css';

const Inicio = () => {
  return (
    <div className="inicio-container">
      {/* SECCIÓN HERO: INTRODUCCIÓN */}
      <section className="hero">
        <div className="hero-content">
          <h1>Statistical Solutions</h1>
          <p className="hero-subtitle">Potenciando el análisis de datos en la ESPOCH</p>
          <p className="hero-description">
            Somos una comunidad apasionada por la estadística y la tecnología, 
            dedicada a transformar datos en soluciones reales para problemas complejos.
          </p>
          <button className="btn-primary-action">Explorar Proyectos</button>
        </div>
      </section>

      {/* SECCIÓN MISIÓN Y VISIÓN */}
      <section className="mision-vision">
        <div className="card-mv">
          <h3>Nuestra Misión</h3>
          <p>
            Promover el interés y el conocimiento en estadística y análisis de datos entre sus miembros, la 
            comunidad politécnica y la sociedad

          </p>
        </div>
        <div className="card-mv">
          <h3>Nuestra Visión</h3>
          <p>
            Crear un entorno de aprendizaje y colaboración donde los estudiantes
            puedan desarrollar habilidades en estadística y aplicarlas en proyectos y actividades prácticas

          </p>
        </div>
      </section>

      {/* SECCIÓN ACTIVIDADES */}
      <section className="actividades">
        <h2>Actividades generales del club</h2>
        <div className="actividades-grid">
          <div className="actividad-item">
            <span className="icon">🎓</span>
            <h4>Eventos Académicos</h4>
            <p>Organizan y/o colaboran en eventos académicos locales, regionales, nacionales e internacionales.</p>
          </div>
          <div className="actividad-item">
            <span className="icon">🛠️</span>
            <h4>Talleres de Refuerzo</h4>
            <p>Planifican el desarrollo de talleres de refuerzo académico según el interés.</p>
          </div>
          <div className="actividad-item">
            <span className="icon">🏢</span>
            <h4>Visitas Guiadas</h4>
            <p>Organizan visitas guiadas a instituciones de investigación, centros 
              tecnológicos empresariales y grupos de formación académica.</p>
          </div>
          <div className="actividad-item">
            <span className="icon">📚</span>
            <h4>Publicación de Libros</h4>
            <p>Contribuyen en la publicación de libros.</p>
          </div>
          <div className="actividad-item">
            <span className="icon">🔬</span>
            <h4>Proyectos de Investigación</h4>
            <p>Colaboran en proyectos de investigación, vinculación y diversas actividades vinculadas 
              a la ciencia, ingeniería, arte y cultura. </p>
          </div>
          <div className="actividad-item">
            <span className="icon">🤝</span>
            <h4>Intercambio de Conocimientos</h4>
            <p>Comparten conocimientos y experiencias con otros estudiantes.</p>
          </div>
          <div className="actividad-item">
            <span className="icon">📊</span>
            <h4>Eventos Estadísticos</h4>
            <p>Participan en eventos académicos y actividades relacionadas con la estadística.</p>
          </div>
          <div className="actividad-item">
            <span className="icon">🌎</span>
            <h4>Colaboración Interinstitucional</h4>
            <p>Colaboran con otros clubs y organizaciones universitarias nacionales e internacionales.</p>
          </div>
          
        </div>
      </section>
    </div>
  );
};

export default Inicio;