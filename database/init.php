<?php

function initDatabase(PDO $pdo): void {
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS projects (
            id          INTEGER PRIMARY KEY AUTOINCREMENT,
            title       TEXT    NOT NULL,
            type        TEXT    NOT NULL DEFAULT '',
            type_bg     TEXT    NOT NULL DEFAULT 'rgba(255,255,255,0.1)',
            type_color  TEXT    NOT NULL DEFAULT '#ffffff',
            short_desc  TEXT    NOT NULL DEFAULT '',
            full_desc   TEXT    NOT NULL DEFAULT '',
            stack       TEXT    NOT NULL DEFAULT '[]',
            stack_colors TEXT   NOT NULL DEFAULT '[]',
            images      TEXT    NOT NULL DEFAULT '[]',
            live_url    TEXT    NOT NULL DEFAULT '#',
            github_url  TEXT    NOT NULL DEFAULT '#',
            figma_url   TEXT    NOT NULL DEFAULT '#',
            sort_order  INTEGER NOT NULL DEFAULT 0,
            created_at  TEXT    NOT NULL DEFAULT (datetime('now'))
        )
    ");

    // Seed sample data only once
    $count = (int) $pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();
    if ($count === 0) {
        $stmt = $pdo->prepare("
            INSERT INTO projects
                (title, type, type_bg, type_color, short_desc, full_desc, stack, stack_colors, images, live_url, github_url, sort_order)
            VALUES
                (:title, :type, :type_bg, :type_color, :short_desc, :full_desc, :stack, :stack_colors, :images, :live_url, :github_url, :sort_order)
        ");

        $samples = [
            [
                'title'       => 'منصة تعليمية MERN',
                'type'        => 'MERN Stack',
                'type_bg'     => 'rgba(245,230,66,0.1)',
                'type_color'  => '#F5E642',
                'short_desc'  => 'منصة تعليمية أونلاين بالـ MERN Stack مع فيديوهات وكويزات تفاعلية.',
                'full_desc'   => 'منصة تعليمية متكاملة مبنية بالـ MERN Stack (MongoDB, Express, React, Node.js). تحتوي على نظام مستخدمين كامل (Instructor / Student)، رفع فيديوهات وملفات PDF، كويزات تفاعلية مع نتائج فورية، نظام تقدم المتعلم، دفع إلكتروني بـ Stripe، وإشعارات Real-time بـ Socket.io. منشورة على Docker مع CI/CD Pipeline.',
                'stack'       => json_encode(['MongoDB','Express','React','Node.js','Socket.io','Docker','Stripe']),
                'stack_colors'=> json_encode(['tag-teal','tag-orange','tag-yellow','tag-orange','tag-teal','tag-teal','tag-yellow']),
                'images'      => json_encode([
                    'https://images.unsplash.com/photo-1501504905252-473c47e087f8?w=800&q=80',
                    'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&q=80',
                ]),
                'live_url'    => '#',
                'github_url'  => 'https://github.com/abdallah-mohamed-dev',
                'sort_order'  => 1,
            ],
        ];

        foreach ($samples as $row) {
            $stmt->execute($row);
        }
    }
}
