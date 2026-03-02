import React, { useEffect, useState } from 'react';
import { supabase } from './../Conexion/supabaseClient.js'; // Ajusta la ruta según tu proyecto
import '../App.css'; // Asumiendo que aquí tienes tus estilos globales y el :root
import './../Css/Actividades_desarrolladas.css';

function Actividades() {
  const [actividades, setActividades] = useState([]);
  const [actividadSeleccionada, setActividadSeleccionada] = useState(null);
  const [cargando, setCargando] = useState(true);

  // Cargar datos desde Supabase al iniciar la página
  useEffect(() => {
    obtenerActividades();
  }, []);

  async function obtenerActividades() {
    try {
      // Llamamos a la tabla 'actividades'
      const { data, error } = await supabase
        .from('actividades')
        .select('*');
      
      if (error) throw error;
      setActividades(data);
    } catch (error) {
      console.error("Error al cargar actividades:", error.message);
    } finally {
      setCargando(false);
    }
  }

  return (
    <div className="contenedor-actividades">
      <h2>Actividades Desarrolladas por el Club</h2>
      
      {cargando ? (
        <p>Cargando actividades...</p>
      ) : (
        <div className="grid-tarjetas">
          {actividades.map((actividad) => (
            <div 
              key={actividad.id} 
              className="tarjeta"
              onClick={() => setActividadSeleccionada(actividad)}
            >
              <img 
                src={actividad.imagen_url || "https://via.placeholder.com/300x150?text=Sin+Imagen"} 
                alt={actividad.nombre} 
                className="tarjeta-img"
              />
              <div className="tarjeta-contenido">
                <h3>{actividad.nombre}</h3>
                <p>{actividad.descripcion_corta}</p>
                <button className="btn-leer-mas">Ver más</button>
              </div>
            </div>
          ))}
        </div>
      )}

      {/* MODAL: Se muestra solo si hay una actividad seleccionada */}
      {actividadSeleccionada && (
        <div className="modal-fondo" onClick={() => setActividadSeleccionada(null)}>
          <div className="modal-contenido" onClick={(e) => e.stopPropagation()}>
            <button className="btn-cerrar" onClick={() => setActividadSeleccionada(null)}>X</button>
            <img 
              src={actividadSeleccionada.imagen_url || "https://via.placeholder.com/600x300?text=Feria+ESPOCH"} 
              alt={actividadSeleccionada.nombre} 
            />
            <h2>{actividadSeleccionada.nombre}</h2>
            <p className="modal-descripcion">{actividadSeleccionada.descripcion_larga}</p>
            {/* Puedes agregar más campos aquí como fecha, lugar, etc. */}
          </div>
        </div>
      )}
    </div>
  );
}

export default Actividades;