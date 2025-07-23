<?php

return [
    'types' => [
        [
            'id' => 'project_manager',
            'name' => 'Project Manager',
            'color' => 'bg-yellow-100 border border-yellow-400 text-yellow-800',
        ],
        [
            'id' => 'developer',
            'name' => 'Developer',
            'color' => 'bg-gray-100 border border-gray-400 text-gray-800',
        ]
    ],
    'categories' => [
        [
            'id' => 'project_manager',
            'name' => 'Project Manager',
            'color' => 'bg-yellow-200 border border-yellow-400 text-yellow-800',
        ],
        [
            'id' => 'front_end',
            'name' => 'Front End',
            'color' => 'bg-yellow-100 border border-yellow-400 text-yellow-700',
        ],
        [
            'id' => 'back_end',
            'name' => 'Back End',
            'color' => 'bg-gray-200 border border-gray-400 text-gray-700',
        ],
        [
            'id' => 'full_stack',
            'name' => 'Full Stack',
            'color' => 'bg-blue-200 border border-blue-400 text-blue-700',
        ],
        [
            'id' => 'cyber_security',
            'name' => 'Cyber Security',
            'color' => 'bg-gray-50 border border-gray-400 text-gray-700',
        ],
    ],
    'workplaces' => [
        [
            'id' => 'smartworking',
            'name' => 'Smartworking',
            'color' => 'bg-orange-100 border border-orange-400 text-orange-700',
        ],
        [
            'id' => 'office',
            'name' => 'In Sede',
            'color' => 'bg-green-100 border border-green-400 text-green-700',
        ]
    ],
    'levels' => [
        [
            'id' => 'junior',
            'name' => 'Junior',
            'color' => 'bg-yellow-100 border border-yellow-400 text-yellow-700',
        ],
        [
            'id' => 'middle',
            'name' => 'Middle',
            'color' => 'bg-blue-100 border border-blue-400 text-blue-700',
        ],
        [
            'id' => 'senior',
            'name' => 'Senior',
            'color' => 'bg-gray-100 border border-gray-400 text-gray-700',
        ]
    ],
    'states_project' => [
        [
            'id' => 'planning',
            'name' => 'In Progettazione',
            'color' => 'bg-yellow-100 border border-yellow-300 text-yellow-700',
        ],
        [
            'id' => 'pending',
            'name' => 'In Sospeso',
            'color' => 'bg-orange-100 border border-orange-300 text-orange-700',
        ],
        [
            'id' => 'deleted',
            'name' => 'Annullato',
            'color' => 'bg-red-100 border border-red-300 text-red-700',
        ],
        [
            'id' => 'delivered',
            'name' => 'Consegnato',
            'color' => 'bg-gray-100 border border-gray-300 text-gray-700',
        ]
    ],
    'approved_types_project' => [
        [
            'id' => 'pending_approval',
            'name' => 'In Approvazione',
            'color' => 'bg-orange-100 border border-orange-300 text-orange-700',
        ],
        [
            'id' => 'approved',
            'name' => 'Approvato',
            'color' => 'bg-yellow-100 border border-yellow-300 text-yellow-700',
        ],
        [
            'id' => 'not_approved',
            'name' => 'Non Approvato',
            'color' => 'bg-red-100 border border-red-300 text-red-700',
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
