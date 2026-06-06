<?php
/**
 * Modelo Estático - Datos del Club (miembros, asesores, estadísticas)
 */
class ClubData {
    public static function getStats() {
        return [
            ['value' => '120+', 'label' => 'Miembros Activos', 'icon' => 'fas fa-users'],
            ['value' => '15+', 'label' => 'Talleres Dictados', 'icon' => 'fas fa-laptop-code'],
            ['value' => '8+', 'label' => 'Proyectos Desarrollados', 'icon' => 'fas fa-project-diagram'],
            ['value' => '6', 'label' => 'Semestres Promoviendo Ciencia', 'icon' => 'fas fa-graduation-cap']
        ];
    }

    public static function getTeamMembers() {
        return [
            ['name' => 'Kevin Yanzapanta', 'role' => 'Presidente', 'photo' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=200&h=200&fit=crop'],
            ['name' => 'Liseth Choto', 'role' => 'Vicepresidenta', 'photo' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=200&h=200&fit=crop'],
            ['name' => 'Paul Vaca', 'role' => 'Secretario', 'photo' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=200&h=200&fit=crop'],
            ['name' => 'Dayra Moyano', 'role' => 'Tesorera', 'photo' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=200&h=200&fit=crop'],
            ['name' => 'Erick Barroso', 'role' => 'Coordinador General', 'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200&h=200&fit=crop']
        ];
    }

    public static function getAdvisors() {
        return [
            ['name' => 'Ing. Nelly Proaño', 'role' => 'Asesora Principal - Docente ESPOCH', 'photo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=200&h=200&fit=crop'],
            ['name' => 'Ing. Juan Carlos Torres', 'role' => 'Co-Asesor - Docente ESPOCH', 'photo' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=200&h=200&fit=crop']
        ];
    }

    public static function getValues() {
        return [
            ['title' => 'Calidad', 'desc' => 'En cada modelo, análisis y entrega de resultados académicos.', 'icon' => 'fas fa-star'],
            ['title' => 'Innovación', 'desc' => 'Uso de tecnologías y metodologías de punta en ciencia de datos.', 'icon' => 'fas fa-lightbulb'],
            ['title' => 'Colaboración', 'desc' => 'Compartir conocimiento y aprender de forma horizontal en equipo.', 'icon' => 'fas fa-handshake'],
            ['title' => 'Responsabilidad', 'desc' => 'Ética en el manejo de datos y fidelidad científica.', 'icon' => 'fas fa-shield-alt']
        ];
    }

    public static function getSocialLinks() {
        return [
            ['url' => '#', 'icon' => 'fab fa-facebook-f', 'name' => 'Facebook'],
            ['url' => '#', 'icon' => 'fab fa-instagram', 'name' => 'Instagram'],
            ['url' => '#', 'icon' => 'fab fa-twitter', 'name' => 'Twitter'],
            ['url' => '#', 'icon' => 'fab fa-linkedin-in', 'name' => 'LinkedIn'],
            ['url' => '#', 'icon' => 'fab fa-whatsapp', 'name' => 'WhatsApp'],
            ['url' => '#', 'icon' => 'fab fa-github', 'name' => 'GitHub']
        ];
    }

    public static function getSkillBars() {
        return [
            ['name' => 'Programación en R & RStudio', 'percent' => 90],
            ['name' => 'Python para Ciencia de Datos (Pandas, Numpy)', 'percent' => 85],
            ['name' => 'Visualización de Datos (ggplot2, Seaborn, PowerBI)', 'percent' => 80],
            ['name' => 'Machine Learning & Modelos Predictivos', 'percent' => 75],
            ['name' => 'Estadística Descriptiva e Inferencial', 'percent' => 95]
        ];
    }
}
