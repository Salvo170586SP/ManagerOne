<?php

return [
    'types' => [
        [
            'id' => 'project_manager',
            'name' => 'Project Manager',
            'color' => 'bg-yellow-700',
        ],
        [
            'id' => 'developer',
            'name' => 'Developer',
            'color' => 'bg-yellow-500',
        ]
    ],
    'categories' => [
        [
            'id' => 'project_manager',
            'name' => 'Project Manager',
            'color' => 'bg-yellow-700',
        ],
        [
            'id' => 'front_end',
            'name' => 'Front end',
            'color' => 'bg-yellow-500',
        ],
        [
            'id' => 'back_end',
            'name' => 'Back end',
            'color' => 'bg-black',
        ],
        [
            'id' => 'full_stack',
            'name' => 'Full stack',
            'color' => 'bg-blue-800',
        ],
        [
            'id' => 'cyber_security',
            'name' => 'Cyber Security',
            'color' => 'bg-gray-600',
        ],
    ],
    'workplaces' => [
        [
            'id' => 'smartworking',
            'name' => 'Smartworking',
            'color' => 'bg-orange-500',
        ],
        [
            'id' => 'office',
            'name' => 'In Sede',
            'color' => 'bg-green-700',
        ]
    ],
    'levels' => [
        [
            'id' => 'junior',
            'name' => 'Junior',
            'color' => 'bg-yellow-500',
        ],
        [
            'id' => 'middle',
            'name' => 'Middle',
            'color' => 'bg-blue-600',
        ],
        [
            'id' => 'senior',
            'name' => 'Senior',
            'color' => 'bg-gray-600',
        ]
    ],
    'states_project' => [
        [
            'id' => 'planning',
            'name' => 'In Progettazione',
            'color' => 'bg-yellow-200',
        ],
        [
            'id' => 'pending',
            'name' => 'In Sospeso',
            'color' => 'bg-yellow-400',
        ],
        [
            'id' => 'deleted',
            'name' => 'Annullato',
            'color' => 'bg-red-200',
        ],
        [
            'id' => 'delivered',
            'name' => 'Consegnato',
            'color' => 'bg-gray-200',
        ]
    ],
    'states_task' => [
        [
            'id' => 'planning',
            'name' => 'In Progettazione',
            'color' => 'bg-green-400',
        ],
        [
            'id' => 'pending',
            'name' => 'In Sospeso',
            'color' => 'bg-yellow-400',
        ],
        [
            'id' => 'deleted',
            'name' => 'Annullato',
            'color' => 'bg-red-400',
        ],
        [
            'id' => 'delivered',
            'name' => 'Consegnato',
            'color' => 'bg-gray-400',
        ]
    ],
    'priorities_task' => [
        [
            'id' => 'low',
            'name' => 'Bassa',
            'color' => 'bg-green-400',
        ],
        [
            'id' => 'medium',
            'name' => 'Media',
            'color' => 'bg-yellow-500',
        ],
        [
            'id' => 'high',
            'name' => 'Alta',
            'color' => 'bg-red-500',
        ]
    ]
];
