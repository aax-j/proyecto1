import React, { useState } from 'react';
import './../Css/Contacto.css';

const Contacto = () => {
  const [form, setForm] = useState({ nombre: '', email: '', mensaje: '' });

  const handleSubmit = (e) => {
    e.preventDefault();
    console.log("Datos enviados:", form);
    alert("¡Gracias por contactar al SSC! Te responderemos pronto.");
  };

  return (
    <div className="contacto-container">
      <header className="contacto-header">
        <h1>Contacto</h1>
        <p>¿Tienes dudas sobre el club o quieres colaborar con nosotros? ¡Escríbenos!</p>
      </header>

      <div className="contacto-content">
        {/* INFO DE CONTACTO */}
        <div className="contacto-info">
          <div className="info-item">
            <span className="info-icon">📍</span>
            <div>
              <h4>Ubicación</h4>
              <p>Escuela Superior Politécnica de Chimborazo (ESPOCH), Facultad de Ciencias, Riobamba.</p>
            </div>
          </div>

          <div className="info-item">
            <span className="info-icon">📧</span>
            <div>
              <h4>Correo Electrónico</h4>
              <p>contacto@ssc-espoch.com</p>
            </div>
          </div>

          <div className="info-item">
            <span className="info-icon">⏰</span>
            <div>
              <h4>Horarios de Reunión</h4>
              <p>Lunes a Viernes: 14:00 - 18:00</p>
            </div>
          </div>
        </div>

        {/* FORMULARIO */}
        <form className="contacto-form" onSubmit={handleSubmit}>
          <div className="form-group">
            <label>Nombre Completo</label>
            <input 
              type="text" 
              placeholder="Tu nombre"
              value={form.nombre}
              onChange={(e) => setForm({...form, nombre: e.target.value})}
              required 
            />
          </div>
          <div className="form-group">
            <label>Correo Institucional</label>
            <input 
              type="email" 
              placeholder="usuario@espoch.edu.ec"
              value={form.email}
              onChange={(e) => setForm({...form, email: e.target.value})}
              required 
            />
          </div>
          <div className="form-group">
            <label>Mensaje</label>
            <textarea 
              rows="5" 
              placeholder="¿En qué podemos ayudarte?"
              value={form.mensaje}
              onChange={(e) => setForm({...form, mensaje: e.target.value})}
              required
            ></textarea>
          </div>
          <button type="submit" className="btn-enviar">Enviar Mensaje</button>
        </form>
      </div>
    </div>
  );
};

export default Contacto;